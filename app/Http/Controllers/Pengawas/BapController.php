<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Models\BapAbsent;
use App\Models\BapSeat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BapController extends Controller
{
    public function index()
    {
        // Only show submitted BAPs (not Drafts) in the main list, OR show drafts with a label
        $baps = Bap::where('user_id', auth()->id())->where('status', '!=', 'DRAFT')->latest()->get();
        // Maybe we want to show drafts too? Let's show everything for now.
        $baps = Bap::where('user_id', auth()->id())->latest()->get();
        return view('pengawas.bap.index', compact('baps'));
    }

    public function create()
    {
        $prodis = \App\Models\Prodi::where('name', '!=', 'S1 Teknik Informatika')->get();
        return view('pengawas.bap.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_kuliah' => 'required|string',
            'kode_mk' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
            'ruang_ujian' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'hari_ujian' => 'required|string',
            'tanggal_ujian' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'jumlah_peserta' => 'required|integer',
            'jumlah_tidak_hadir' => 'required|integer',
            'catatan_peristiwa' => 'nullable|string',
            'pengawas_1' => 'required|string',
            'pengawas_2' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $filePath = null;
            if ($request->hasFile('lampiran')) {
                $filePath = $request->file('lampiran')->store('lampiran_bap', 'public');
            }

            // Create as DRAFT
            $bap = Bap::create([
                'user_id' => auth()->id(),
                'mata_kuliah' => $request->mata_kuliah,
                'kode_mk' => $request->kode_mk,
                'prodi_id' => $request->prodi_id,
                'ruang_ujian' => $request->ruang_ujian,
                'tahun_ajaran' => $request->tahun_ajaran,
                'hari_ujian' => $request->hari_ujian,
                'tanggal_ujian' => $request->tanggal_ujian,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'jumlah_peserta' => $request->jumlah_peserta,
                'jumlah_tidak_hadir' => $request->jumlah_tidak_hadir,
                'catatan_peristiwa' => $request->catatan_peristiwa ?? '-',
                'pengawas_1' => $request->pengawas_1,
                'pengawas_2' => $request->pengawas_2,
                'lampiran' => $filePath,
                'status' => 'DRAFT',
            ]);

            // Save Absents if any
            if ($request->has('absent') && is_array($request->absent)) {
                foreach ($request->absent as $ab) {
                    if (!empty($ab['nim']) && !empty($ab['nama'])) {
                        BapAbsent::create([
                            'bap_id' => $bap->id,
                            'nim' => $ab['nim'],
                            'nama' => $ab['nama'],
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->input('action') === 'denah') {
                return redirect()->route('pengawas.bap.denah', ['bap' => $bap->id]);
            }

            if ($request->input('action') === 'preview') {
                return redirect()->route('pengawas.bap.preview', $bap->id);
            }

            return redirect()->route('pengawas.bap.index')->with('success', 'Draft BAP berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Bap $bap)
    {
        if ($bap->user_id !== auth()->id() || $bap->status !== 'DRAFT') {
            abort(403);
        }
        $bap->load('absents');
        $prodis = \App\Models\Prodi::where('name', '!=', 'S1 Teknik Informatika')->get();
        return view('pengawas.bap.create', compact('bap', 'prodis'));
    }

    public function update(Request $request, Bap $bap)
    {
        if ($bap->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'mata_kuliah' => 'required|string',
            'kode_mk' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
            'ruang_ujian' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'hari_ujian' => 'required|string',
            'tanggal_ujian' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'jumlah_peserta' => 'required|integer',
            'jumlah_tidak_hadir' => 'required|integer',
            'catatan_peristiwa' => 'nullable|string',
            'pengawas_1' => 'required|string',
            'pengawas_2' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('lampiran')) {
                $bap->lampiran = $request->file('lampiran')->store('lampiran_bap', 'public');
            }

            $bap->update([
                'mata_kuliah' => $request->mata_kuliah,
                'kode_mk' => $request->kode_mk,
                'prodi_id' => $request->prodi_id,
                'ruang_ujian' => $request->ruang_ujian,
                'tahun_ajaran' => $request->tahun_ajaran,
                'hari_ujian' => $request->hari_ujian,
                'tanggal_ujian' => $request->tanggal_ujian,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'jumlah_peserta' => $request->jumlah_peserta,
                'jumlah_tidak_hadir' => $request->jumlah_tidak_hadir,
                'catatan_peristiwa' => $request->catatan_peristiwa ?? '-',
                'pengawas_1' => $request->pengawas_1,
                'pengawas_2' => $request->pengawas_2,
            ]);

            // Sync Absents (Delete all and recreate is easiest)
            BapAbsent::where('bap_id', $bap->id)->delete();
            if ($request->has('absent') && is_array($request->absent)) {
                foreach ($request->absent as $ab) {
                    if (!empty($ab['nim']) && !empty($ab['nama'])) {
                        BapAbsent::create([
                            'bap_id' => $bap->id,
                            'nim' => $ab['nim'],
                            'nama' => $ab['nama'],
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->input('action') === 'denah') {
                return redirect()->route('pengawas.bap.denah', ['bap' => $bap->id]);
            }

            if ($request->input('action') === 'preview') {
                return redirect()->route('pengawas.bap.preview', $bap->id);
            }

            return redirect()->route('pengawas.bap.index')->with('success', 'BAP updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }

    public function denah(Request $request)
    {
        // If BAP ID is passed via query param or route param
        // In store() we used route params: route('pengawas.bap.denah', ['bap' => $bap->id])
        // So we need to accept $bap logic. 
        // But wait, the route definition in web.php was Route::get('/bap/denah', ...)
        // We need to change that route to /bap/{bap}/denah
        // For now, I'll rely on the query string ?bap=ID if I keep the old route, OR I'll assume I update the route.
        // Let's assume I update the route to accept ID.

        $bapId = $request->bap ?? $request->query('bap');
        if (!$bapId) {
            $bapId = session('last_bap_id'); // Fallback
        }

        $bap = Bap::find($bapId);

        if (!$bap || $bap->user_id !== auth()->id()) {
            return redirect()->route('pengawas.bap.index')->with('error', 'BAP tidak ditemukan.');
        }

        return view('pengawas.bap.denah', compact('bap'));
    }

    public function denahStore(Request $request)
    {
        $bapId = $request->bap_id;
        $bap = Bap::find($bapId);

        if (!$bap || $bap->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['seat' => 'required|array']);

        DB::beginTransaction();
        try {
            BapSeat::where('bap_id', $bapId)->delete();
            foreach ($request->seat as $idx => $nim) {
                if (!empty($nim)) {
                    BapSeat::create([
                        'bap_id' => $bapId,
                        'seat_number' => $idx + 1,
                        'nim' => $nim,
                    ]);
                }
            }
            DB::commit();

            // Redirect back to Edit BAP
            return redirect()->route('pengawas.bap.edit', $bap->id)->with('success', 'Denah berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function preview(Bap $bap)
    {
        if ($bap->user_id !== auth()->id()) {
            abort(403);
        }
        $bap->load(['absents', 'seats']);
        return view('pengawas.bap.preview', compact('bap'));
    }

    public function submit(Bap $bap)
    {
        if ($bap->user_id !== auth()->id()) {
            abort(403);
        }

        $bap->update(['status' => 'PENDING']);

        return redirect()->route('pengawas.dashboard')->with('success', 'BAP berhasil disubmit!');
    }
}
