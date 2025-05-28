<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login dulu');
            return redirect('/login')->with('error', 'Silakan login dulu');
        }

        // Cek rolenya
        if (Auth::user()->role !== $role) {
            logger('Role user saat ini: ' . Auth::user()->role);
            return redirect('/')->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}
