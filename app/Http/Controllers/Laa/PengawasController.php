<?php

namespace App\Http\Controllers\Laa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengawasController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'PENGAWAS');

        // Filter search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%$q%")
                    ->orWhere('nip', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        // Filter prodi
        if ($request->filled('prodi') && $request->prodi !== 'ALL') {
            $query->where('prodi_id', $request->prodi);
        }

        // Filter status
        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }

        $pengawas = $query->with('prodi')->get();
        $prodis = Prodi::where('name', '!=', 'S1 Teknik Informatika')->get();

        return view('laa.pengawas.index', compact('pengawas', 'prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'prodi_id' => 'required|exists:prodis,id',
            'status' => 'required|in:AKTIF,NONAKTIF',
        ]);

        $validated['password'] = Hash::make('password123'); // Default password
        $validated['role'] = 'PENGAWAS';

        User::create($validated);

        return redirect()->back()->with('success', 'Pengawas berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'prodi_id' => 'required|exists:prodis,id',
            'status' => 'required|in:AKTIF,NONAKTIF',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Data pengawas berhasil diperbarui.');
    }

    public function toggleActive(User $user)
    {
        $user->status = $user->status === 'AKTIF' ? 'NONAKTIF' : 'AKTIF';
        $user->save();

        return redirect()->back()->with('success', 'Status akun berhasil diubah.');
    }

    public function resetPassword(User $user)
    {
        $user->password = Hash::make('password123');
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil di-reset ke "password123".');
    }
}
