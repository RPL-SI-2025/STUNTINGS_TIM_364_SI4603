<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);  // Izinkan akses jika role = 'admin'
        }

        // Jika user tidak memiliki role 'admin', redirect ke login
        return redirect()->route('login')->with('error', 'Access denied. Admins only.');
    }
}
