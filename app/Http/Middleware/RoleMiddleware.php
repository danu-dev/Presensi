<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Mengecek apakah peran pengguna saat ini tidak sama dengan peran yang dibutuhkan
        if (auth()->user()->role !== $role) {
            // Jika berbeda, arahkan kembali ke halaman utama dengan pesan error
            return redirect('/')->with('error', 'Akses ditolak.');
        }
        
        // Jika peran sesuai, lanjutkan permintaan ke langkah berikutnya
        return $next($request);
    }
}
