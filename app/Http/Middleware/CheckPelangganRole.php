<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPelangganRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $role = auth()->user()->role;

        if ($role !== 'pelanggan') {
            // Arahkan sesuai role
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'penjual':
                case 'pembeli':
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
