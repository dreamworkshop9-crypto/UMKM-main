<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{


    private function cekRole()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya untuk admin.');
        }
    }

    public function index()
    {
        $this->cekRole();

        // 1. Core Statistics
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::whereIn('payment_status', ['paid', 'lunas'])->sum('total');
        $totalProducts = \App\Models\Product::count();
        $pendingOrders = \App\Models\Order::where('status', 'menunggu')->count();

        // 2. Best Selling Products (Top 5)
        $bestSellers = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_sold'), \Illuminate\Support\Facades\DB::raw('SUM(quantity * price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get();

        // 3. Recent Orders (Top 5)
        $recentOrders = \App\Models\Order::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'pendingOrders',
            'bestSellers',
            'recentOrders'
        ));
    }

    public function pesanan()
    {
        $this->cekRole();
        return view('pages.placeholder', ['title' => 'Pesanan']);
    }

    public function editProfile()
    {
        $this->cekRole();
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->cekRole();
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil admin berhasil diperbarui.');
    }
}