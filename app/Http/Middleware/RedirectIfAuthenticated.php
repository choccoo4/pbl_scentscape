<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            // Redirect sesuai role
            if ($role === 'pembeli') {
                return redirect('/home');
            } elseif ($role === 'penjual') {
                return redirect('/seller/dashboard');
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
