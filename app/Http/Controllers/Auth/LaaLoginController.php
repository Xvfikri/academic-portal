<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaaLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'], // In UI it's labeled username but for LAA it's email
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'LAA', 'status' => 'AKTIF'])) {
            $request->session()->regenerate();
            return redirect()->intended('/laa/dashboard');
        }

        return back()->withErrors([
            'login' => 'Username/Password salah atau kredensial bukan LAA.',
        ])->onlyInput('username');
    }
}
