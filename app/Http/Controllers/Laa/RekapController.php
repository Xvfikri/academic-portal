<?php

namespace App\Http\Controllers\Laa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Models\Prodi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        // Filters
        $periode = $request->input('periode');
        $prodiId = $request->input('prodi_id');
        $jenis = $request->input('jenis', 'summary'); // summary, detail

        // Dropdown Data
        $periodes = Bap::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');
        $prodis = Prodi::where('name', '!=', 'S1 Teknik Informatika')->get();

        // Check if filter button clicked (param 'jenis' exists)
        if (!$request->has('jenis')) {
            $baps = null;
            $stats = [];
            $perPengawas = [];
            return view('laa.rekap.index', compact('baps', 'stats', 'perPengawas', 'periodes', 'prodis', 'periode', 'prodiId', 'jenis'));
        }

        // Setup Query
        // USE 'prodi' from BAP, not user.
        $query = Bap::query()->with(['user', 'prodi']);

        if ($periode) {
            $query->where('tahun_ajaran', $periode);
        }

        if ($prodiId) {
            // DIRECT FILTER on BAP table
            $query->where('prodi_id', $prodiId);
        }

        $baps = $query->latest()->get();

        // Data for Summary
        $stats = [
            'total' => $baps->count(),
            'verified' => $baps->where('status', 'APPROVED')->count(),
            'pending' => $baps->where('status', 'PENDING')->count(),
            'rejected' => $baps->where('status', 'REJECTED')->count(),
        ];

        // Data for Per Pengawas
        $perPengawas = [];
        if ($jenis == 'per_pengawas') {
            // Group by User ID
            $grouped = $baps->groupBy('user_id');
            foreach ($grouped as $userId => $items) {
                // If user_id is null, it might be manual input, group by 'pengawas_1' name instead?
                // For now assuming all have user_id if they are pengawas users.
                // If user_id is null, key is "" (empty string).

                $user = $items->first()->user;
                $name = $user ? $user->name : ($items->first()->pengawas_1 ?? 'Unknown');
                $nip = $user ? $user->nip : '-';

                $perPengawas[] = [
                    'name' => $name,
                    'nip' => $nip,
                    'total' => $items->count(),
                    'approved' => $items->where('status', 'APPROVED')->count(),
                    'pending' => $items->where('status', 'PENDING')->count(),
                    'rejected' => $items->where('status', 'REJECTED')->count(),
                ];
            }
            // Sort by Name
            usort($perPengawas, fn($a, $b) => strcmp($a['name'], $b['name']));
        }

        return view('laa.rekap.index', compact('baps', 'stats', 'perPengawas', 'periodes', 'prodis', 'periode', 'prodiId', 'jenis'));
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'pdf'); // pdf, excel
        $periode = $request->input('periode');
        $prodiId = $request->input('prodi_id');
        $jenis = $request->input('jenis', 'summary');

        $query = Bap::query()->with(['user', 'prodi']);

        if ($periode) {
            $query->where('tahun_ajaran', $periode);
        }

        if ($prodiId) {
            // DIRECT FILTER on BAP table
            $query->where('prodi_id', $prodiId);
        }

        $baps = $query->latest()->get();
        $prodiName = $prodiId ? Prodi::find($prodiId)->name : 'Semua Program Studi';

        $perPengawas = [];
        if ($jenis == 'per_pengawas') {
            $grouped = $baps->groupBy('user_id');
            foreach ($grouped as $userId => $items) {
                $user = $items->first()->user;
                $name = $user ? $user->name : ($items->first()->pengawas_1 ?? 'Unknown');
                $nip = $user ? $user->nip : '-';
                $perPengawas[] = [
                    'name' => $name,
                    'nip' => $nip,
                    'total' => $items->count(),
                    'approved' => $items->where('status', 'APPROVED')->count(),
                    'pending' => $items->where('status', 'PENDING')->count(),
                    'rejected' => $items->where('status', 'REJECTED')->count(),
                    'details' => $items
                ];
            }
            usort($perPengawas, fn($a, $b) => strcmp($a['name'], $b['name']));
        }

        $data = compact('baps', 'periode', 'prodiName', 'jenis', 'perPengawas');

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('laa.rekap.pdf', $data);
            return $pdf->download('Rekap_BAP_' . now()->format('Ymd_His') . '.pdf');
        }

        if ($type === 'excel') {
            // Simple HTML to Excel (Works for this scale)
            // Headers for Excel download
            return response(view('laa.rekap.excel', $data))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="Rekap_BAP_' . now()->format('Ymd_His') . '.xls"');
        }

        return back();
    }
}
