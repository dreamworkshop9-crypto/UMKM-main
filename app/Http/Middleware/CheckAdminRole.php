<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $role = auth()->user()->role;

        if ($role !== 'admin') {
            // Arahkan sesuai role
            switch ($role) {
                case 'pelanggan':
                    return redirect()->route('shop');
                case 'penjual':
                case 'pembeli':
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
