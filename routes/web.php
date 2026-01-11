<?php

use Illuminate\Support\Facades\Route;

// Controller Auth
use App\Http\Controllers\Auth\LoginPageController;
use App\Http\Controllers\Auth\LaaLoginController;
use App\Http\Controllers\Auth\PengawasLoginController;

// Controller Fitur
use App\Http\Controllers\Laa\DashboardController;
use App\Http\Controllers\Laa\JadwalController;
use App\Http\Controllers\Laa\PengawasController; // [BARU] Import Controller Manajemen Pengawas
use App\Http\Controllers\Pengawas\PasswordController;
use App\Http\Controllers\Pengawas\BapController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login.page'));

// Halaman Login
Route::get('/login', [LoginPageController::class, 'show'])->name('login.page');

// Aksi Login
Route::post('/login/laa', [LaaLoginController::class, 'login'])->name('login.laa');
Route::post('/login/pengawas', [PengawasLoginController::class, 'login'])->name('login.pengawas');

// Logout
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login.page');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Redirect Logic
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $u = auth()->user();
    if (!$u)
        return redirect()->route('login.page');

    return $u->role === 'LAA'
        ? redirect()->route('laa.dashboard')
        : redirect()->route('pengawas.dashboard');
})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| AREA PENGAWAS (User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:PENGAWAS'])
    ->prefix('pengawas')
    ->name('pengawas.')
    ->group(function () {

        Route::get('/', fn() => redirect()->route('pengawas.dashboard'))->name('home');

        // GANTI PASSWORD
        Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password', [PasswordController::class, 'update'])->name('password.update');

        // AREA TERKUNCI (Wajib ganti password dulu)
        Route::middleware('force_password')->group(function () {

            Route::get('/dashboard', fn() => view('pengawas.dashboard'))->name('dashboard');

            // --- MANAJEMEN BAP ---
            Route::get('/bap', [BapController::class, 'index'])->name('bap.index');
            Route::get('/bap/create', [BapController::class, 'create'])->name('bap.create');
            Route::post('/bap', [BapController::class, 'store'])->name('bap.store');
            Route::get('/bap/{bap}/edit', [BapController::class, 'edit'])->name('bap.edit');
            Route::put('/bap/{bap}', [BapController::class, 'update'])->name('bap.update');
            Route::get('/bap/{bap}/preview', [BapController::class, 'preview'])->name('bap.preview');
            Route::post('/bap/{bap}/submit', [BapController::class, 'submit'])->name('bap.submit');

            // --- DENAH ---
            // Route now accepts BAP ID
            Route::get('/bap/{bap}/denah', [BapController::class, 'denah'])->name('bap.denah');
            Route::post('/bap/denah', [BapController::class, 'denahStore'])->name('bap.denah.store');

            // --- NOTIFIKASI ---
            Route::get('/notifications', [App\Http\Controllers\Pengawas\NotificationController::class, 'index'])->name('notifications.index');

            // --- PROFIL ---
            Route::get('/profil', [App\Http\Controllers\Pengawas\ProfileController::class, 'index'])->name('profil');
            Route::put('/profil', [App\Http\Controllers\Pengawas\ProfileController::class, 'update'])->name('profil.update');
            Route::view('/settings', 'pengawas.settings')->name('settings');
        });
    });


/*
|--------------------------------------------------------------------------
| AREA LAA (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:LAA'])
    ->prefix('laa')
    ->name('laa.')
    ->group(function () {

        Route::get('/', fn() => redirect()->route('laa.dashboard'))->name('home');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ==========================================
        // MANAJEMEN PENGAWAS (UPDATED)
        // ==========================================
        // Ini adalah rute CRUD lengkap untuk mengelola akun pengawas
        Route::get('/pengawas', [PengawasController::class, 'index'])->name('pengawas.index');
        Route::post('/pengawas', [PengawasController::class, 'store'])->name('pengawas.store');
        Route::put('/pengawas/{user}', [PengawasController::class, 'update'])->name('pengawas.update');
        Route::post('/pengawas/{user}/toggle', [PengawasController::class, 'toggleActive'])->name('pengawas.toggle');
        Route::post('/pengawas/{user}/reset-password', [PengawasController::class, 'resetPassword'])->name('pengawas.resetPassword');


        // ==========================================
        // MANAJEMEN JADWAL
        // ==========================================
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');


        // ==========================================
        // MANAJEMEN BAP & REKAP
        // ==========================================
        // MANAJEMEN BAP & REKAP
        // ==========================================
        Route::get('/bap', [App\Http\Controllers\Laa\BapController::class, 'index'])->name('bap.index');
        Route::post('/bap/{bap}/verify', [App\Http\Controllers\Laa\BapController::class, 'verify'])->name('bap.verify');
        Route::post('/bap/{bap}/reject', [App\Http\Controllers\Laa\BapController::class, 'reject'])->name('bap.reject');
        Route::get('/bap/{bap}/preview', [App\Http\Controllers\Laa\BapController::class, 'preview'])->name('bap.preview');

        Route::get('/rekap', [App\Http\Controllers\Laa\RekapController::class, 'index'])->name('rekap.index');
        Route::get('/rekap/export', [App\Http\Controllers\Laa\RekapController::class, 'export'])->name('rekap.export');
        Route::view('/settings', 'laa.settings')->name('settings');
    });