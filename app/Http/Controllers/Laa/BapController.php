<?php

namespace App\Http\Controllers\Laa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;

class BapController extends Controller
{
    public function index(Request $request)
    {
        $query = Bap::with('user');

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('mata_kuliah', 'like', "%$q%")
                    ->orWhere('kode_mk', 'like', "%$q%")
                    ->orWhere('pengawas_1', 'like', "%$q%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$q%"));
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }

        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_ujian', '>=', $request->date_from);
        }

        $baps = $query->latest()->get();

        return view('laa.bap.index', compact('baps'));
    }

    public function verify(Bap $bap)
    {
        $bap->update([
            'status' => 'APPROVED',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        return back()->with('success', 'BAP berhasil diverifikasi.');
    }

    public function reject(Request $request, Bap $bap)
    {
        $request->validate(['reason' => 'required|string']);

        $bap->update([
            'status' => 'REJECTED',
            'catatan_admin' => $request->reason,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        return back()->with('success', 'BAP berhasil ditolak.');
    }

    public function preview(Bap $bap)
    {
        // View same as Pengawas
        $bap->load(['absents', 'seats']);
        return view('pengawas.bap.preview', compact('bap'));
    }
}
