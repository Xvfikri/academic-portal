<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengawasLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'], // For pengawas it is NIP
            'password' => ['required'],
        ]);

        if (Auth::attempt(['nip' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'PENGAWAS', 'status' => 'AKTIF'])) {
            $request->session()->regenerate();
            return redirect()->intended('/pengawas/dashboard');
        }

        return back()->withErrors([
            'login' => 'NIP/Password salah atau akun nonaktif.',
        ])->onlyInput('username');
    }
}
