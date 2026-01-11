<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalBap = \App\Models\Bap::where('user_id', $user->id)->count();
        $pendingBap = \App\Models\Bap::where('user_id', $user->id)->where('status', 'PENDING')->count();

        return view('pengawas.profil', compact('user', 'totalBap', 'pendingBap'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate basic info
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
