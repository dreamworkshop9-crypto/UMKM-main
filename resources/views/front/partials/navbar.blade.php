<nav id="navbar" class="glass fixed top-0 left-0 right-0 z-50 border-b border-sf-600/20 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-[72px]">
            <a href="{{ route('front.home') }}" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:shadow-brand-500/40 transition-shadow"><i class="fa-solid fa-shoe-prints text-white text-sm"></i></div>
                <span class="text-xl font-extrabold tracking-tight">SALZA</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Beranda</a>
                <a href="#produk" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Produk</a>
                <a href="#tentang" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Tentang</a>
                <a href="#cara-pesan" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cara Pesan</a>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all"><i class="fa-solid fa-magnifying-glass text-sm"></i></button>
                <button onclick="openCart()" class="relative w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all group">
                    <i class="fa-solid fa-bag-shopping text-sm group-hover:scale-110 transition-transform"></i>
                    <span id="cart-badge" class="hidden absolute -top-1 -right-1 min-w-[20px] h-5 bg-brand-500 text-white text-[10px] font-bold rounded-full items-center justify-center px-1 shadow-lg shadow-brand-500/40">0</span>
                </button>
                @guest
                <button onclick="openAuthModal('login')" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40"><i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk</button>
                @endguest
                @auth
                <a href="{{ route('shop') }}?open_account=pesanan" onclick="if(typeof openAccount !== 'undefined') { event.preventDefault(); openAccount('pesanan'); }" class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 bg-sf-700/50 hover:bg-sf-700 text-white text-sm font-medium rounded-xl transition-all border border-sf-600/20"><i class="fa-solid fa-box text-xs text-brand-400"></i> Pesanan</a>
                <div class="hidden sm:block relative" id="dd-wrap">
                    <button onclick="document.getElementById('dd-menu').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-sf-700/50 transition-all">
                        <div class="w-8 h-8 bg-brand-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-user text-brand-400 text-xs"></i></div>
                        <span class="text-sm text-slate-300 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
                    </button>
                    <div id="dd-menu" class="hidden absolute right-0 top-full mt-2 w-56 bg-sf-700 border border-sf-600/20 rounded-xl shadow-2xl overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-sf-600/20"><p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p><p class="text-xs text-slate-500">{{ auth()->user()->email }}</p></div>
                        <div class="py-1">
                            <a href="{{ route('shop') }}?open_account=dashboard" onclick="if(typeof openAccount !== 'undefined') { event.preventDefault(); openAccount('dashboard'); }" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-sf-600/30"><i class="fa-solid fa-gauge w-4 text-center text-slate-500"></i>Dashboard Saya</a>
                            <a href="{{ route('shop') }}?open_account=pesanan" onclick="if(typeof openAccount !== 'undefined') { event.preventDefault(); openAccount('pesanan'); }" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-sf-600/30"><i class="fa-solid fa-box w-4 text-center text-slate-500"></i>Pesanan Saya</a>
                            <a href="{{ route('shop') }}?open_account=profil" onclick="if(typeof openAccount !== 'undefined') { event.preventDefault(); openAccount('profil'); }" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-sf-600/30"><i class="fa-solid fa-user-gear w-4 text-center text-slate-500"></i>Edit Profil</a>
                        </div>
                        <div class="border-t border-sf-600/20 py-1">
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-rose-400 hover:bg-rose-500/10"><i class="fa-solid fa-right-from-bracket w-4 text-center"></i>Keluar</button></form>
                        </div>
                    </div>
                </div>
                @endauth
                <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all"><i id="mob-icon" class="fa-solid fa-bars"></i></button>
            </div>
        </div>
    </div>
    <div id="search-bar" class="hidden border-t border-sf-600/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="relative max-w-xl mx-auto">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                <input id="search-input" type="text" placeholder="Cari sepatu impianmu..." class="w-full pl-11 pr-12 py-3.5 bg-sf-700/50 border border-sf-600/50 rounded-2xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all" oninput="filterProducts()">
                <button onclick="toggleSearch()" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:text-white hover:bg-sf-600/50 transition-all"><i class="fa-solid fa-xmark text-xs"></i></button>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden border-t border-sf-600/20">
        <div class="px-4 py-4 space-y-1">
            <a href="#beranda" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-sf-700/50 rounded-xl">Beranda</a>
            <a href="#produk" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-sf-700/50 rounded-xl">Produk</a>
            <a href="#tentang" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-sf-700/50 rounded-xl">Tentang</a>
            <a href="#cara-pesan" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-sf-700/50 rounded-xl">Cara Pesan</a>
            @guest
            <button onclick="openAuthModal('login');toggleMobileMenu();" class="block w-full text-left px-4 py-3 text-sm font-semibold text-brand-400 hover:bg-brand-500/10 rounded-xl"><i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk / Daftar</button>
            @endguest
            @auth
            <a href="{{ route('shop') }}?open_account=pesanan" onclick="toggleMobileMenu(); if(typeof openAccount !== 'undefined') { event.preventDefault(); openAccount('pesanan'); }" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:bg-sf-700/50 rounded-xl"><i class="fa-solid fa-box mr-2"></i>Pesanan Saya</a>
            <form method="POST" action="{{ route('logout') }}" class="block">@csrf<button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-rose-400 hover:bg-rose-500/10 rounded-xl"><i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar</button></form>
            @endauth
        </div>
    </div>
</nav>