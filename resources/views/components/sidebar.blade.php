<aside class="w-64 bg-dashboard-card flex-shrink-0 flex flex-col border-r border-slate-700/50" data-purpose="sidebar-navigation">
    <!-- Logo Section -->
    <div class="p-6 flex items-center space-x-2">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xl">S</span>
        </div>
        <span class="text-2xl font-bold text-white tracking-wider">SALZA</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto px-4 py-2 custom-scrollbar text-sm">

        <!-- Dashboard -->
        <div class="mb-6">
            <a class="flex items-center px-4 py-3 rounded-lg transition-all @if(Route::currentRouteName() === 'dashboard') text-white shadow-lg shadow-purple-500/20 bg-slate-700/50 @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('dashboard') }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                Dashboard
            </a>
        </div>

        <!-- Data Master -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Data Master</p>
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'brands.index') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('brands.index') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Merek
                        </span>
                        <svg class="w-3 h-3 @if(Route::currentRouteName() === 'brands.index') text-white @else text-slate-500 group-hover:text-white @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'kategori') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('kategori') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Kategori
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'produk') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('produk') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Produk
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'slider') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('slider') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Slider
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'kupon') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('kupon') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Kupon
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'wilayah') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('wilayah') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Data Wilayah
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Kelola Pesanan -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Kelola Pesanan</p>
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'pesanan') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('pesanan') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Pesanan
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'pembatalan') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('pembatalan') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Pembatalan
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'pengembalian') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('pengembalian') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Pengembalian
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'ulasan') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('ulasan') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Ulasan
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'stok') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('stok') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Stok Produk
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Pengaturan -->
        <div class="mb-6">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'users') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('users') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Data User
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'admins') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('admins') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Data Admin
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors @if(Route::currentRouteName() === 'laporan') bg-slate-700/50 text-white @else text-slate-400 hover:bg-slate-700/50 hover:text-white @endif" href="{{ route('laporan') }}">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Laporan
                        </span>
                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>