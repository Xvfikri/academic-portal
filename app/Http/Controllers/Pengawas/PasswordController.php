<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('pengawas.force-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = $request->user();

        // update password + matikan flag force change
        $user->password = Hash::make($request->password);
        $user->force_change_password = false; // atau 0
        $user->save();

        // supaya tidak balik lagi ke halaman force password
        return redirect()->route('pengawas.dashboard')
            ->with('success', 'Password berhasil diganti.');
    }
}
