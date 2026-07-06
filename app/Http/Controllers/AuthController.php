<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) return $this->redirectByRole();
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        if (auth()->check()) return $this->redirectByRole();
        return view('pages.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole()->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone ?? $request->whatsapp,
            'role'     => 'pelanggan',
        ]);

        Auth::login($user);
        return redirect()->route('shop')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('shop')->with('success', 'Berhasil keluar.');
    }

    private function redirectByRole()
    {
        $userRole = strtolower(auth()->user()->role ?? 'pelanggan');

        $routes = [
            'admin'     => 'admin.dashboard',
            'pelanggan' => 'shop',
            'penjual'   => 'shop',
            'pembeli'   => 'shop',
        ];

        $target = $routes[$userRole] ?? 'shop';

        if (Route::has($target)) {
            return redirect()->route($target);
        }

        return redirect()->route('login');
    }
}
