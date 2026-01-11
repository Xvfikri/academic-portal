<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceChangePassword
{
    public function handle($request, \Closure $next)
{
    $user = $request->user();

    if (!$user) return $next($request);

    // bypass halaman ganti password
    if ($request->routeIs('pengawas.password.*')) {
        return $next($request);
    }

    if ($user->role === 'PENGAWAS' && $user->force_change_password) {
        return redirect()->route('pengawas.password.edit');
    }

    return $next($request);
}
}
