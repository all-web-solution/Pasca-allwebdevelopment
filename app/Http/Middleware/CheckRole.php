<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // PERHATIKAN BARIS DI BAWAH INI, ADA TAMBAHAN ...$roles
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            // Jika role tidak cocok, tendang ke halaman 403 Forbidden
            abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin administrator untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
