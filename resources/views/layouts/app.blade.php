<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'SALZA - Toko Sepatu Online')</title>
    <link rel="icon" href="{{ asset('image/waku.jpeg') }}?v=1.0.1" type="image/jpeg">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: #f8fafc; }
        .glass-nav { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -4px; left: 0; background: #a855f7; transition: width 0.3s ease; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        /* Dropdown */
        .group:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen selection:bg-purple-500/30 selection:text-purple-200">

    <!-- Topbar -->
    <div class="bg-slate-950 py-2 border-b border-slate-800/50 hidden sm:block">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center text-[11px] font-medium text-slate-400 tracking-wider uppercase">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-map-marker-alt text-purple-400 mr-1.5"></i> Jl. Babakan Tiga No. 82 Ciwidey</span>
                <span><i class="fa-solid fa-envelope text-emerald-400 mr-1.5"></i> esalza@gmail.com</span>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('order.index') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-box-open mr-1"></i> Pesanan</a>
                    <button onclick="openTrack()" class="hover:text-amber-400 transition-colors"><i class="fa-solid fa-truck-fast mr-1"></i> Lacak</button>
                    <div class="w-px h-3 bg-slate-700"></div>
                    <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">@csrf
                        <button type="submit" class="hover:text-rose-400 transition-colors"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar ({{ Auth::user()->name }})</button>
                    </form>
                @else
                    <button onclick="openTrack()" class="hover:text-amber-400 transition-colors"><i class="fa-solid fa-truck-fast mr-1"></i> Lacak Pesanan</button>
                    <div class="w-px h-3 bg-slate-700"></div>
                    <a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a>
                    <a href="{{ route('daftar') }}" class="hover:text-purple-400 transition-colors">Daftar</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <header class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20 gap-8">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter text-white flex-shrink-0 flex items-center gap-2">
                    <img src="{{ asset('image/waku.jpeg') }}" class="w-9 h-9 rounded-lg object-cover" alt="SALZA Logo">
                    <span>SAL<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-emerald-400">ZA</span></span>
                </a>

                <!-- Navigation -->
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link text-sm font-semibold text-slate-300 hover:text-white {{ request()->routeIs('home') ? 'active text-white' : '' }}">Beranda</a>
                    
                    @foreach($categories ?? [] as $cat)
                    <div class="relative group py-8">
                        <a href="{{ route('shop',['category'=>$cat->slug]) }}" class="nav-link text-sm font-semibold text-slate-300 hover:text-white flex items-center gap-1.5">
                            {{ $cat->name }} <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 group-hover:text-purple-400 transition-colors"></i>
                        </a>
                        @if($cat->children->count())
                        <div class="dropdown-menu absolute top-[70px] left-0 w-64 bg-slate-800 border border-slate-700/50 rounded-2xl shadow-2xl shadow-black/50 opacity-0 invisible translate-y-2 transition-all duration-300 overflow-hidden">
                            @foreach($cat->children as $sub)
                            <div class="p-4 border-b border-slate-700/50 last:border-0">
                                <h4 class="text-[11px] font-bold uppercase tracking-wider text-purple-400 mb-2 px-2">{{ $sub->name }}</h4>
                                <div class="flex flex-col">
                                    @foreach($sub->children as $ss)
                                    <a href="{{ route('product.subsubcategory',[$ss->id,$ss->slug]) }}" class="px-2 py-1.5 text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-colors">{{ $ss->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    <a href="{{ route('shop') }}" class="nav-link text-sm font-semibold text-slate-300 hover:text-white {{ request()->routeIs('shop') ? 'active text-white' : '' }}">Belanja</a>
                    <a href="{{ route('shop',['sort'=>'price_asc']) }}" class="text-sm font-bold text-amber-400 hover:text-amber-300 transition-colors">PROMO 🔥</a>
                </nav>

                <!-- Search & Actions -->
                <div class="flex items-center gap-4 flex-1 justify-end">
                    <!-- Search Bar -->
                    <form action="{{ route('shop') }}" method="GET" class="hidden md:flex relative w-full max-w-xs group">
                        <input type="text" name="q" placeholder="Cari sepatu impianmu..." value="{{ request('q') }}" class="w-full bg-slate-900 border border-slate-700 rounded-full py-2 pl-4 pr-10 text-sm text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all outline-none">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 group-hover:text-purple-400 transition-colors"><i class="fa-solid fa-search"></i></button>
                    </form>

                    <!-- Icons -->
                    <div class="flex items-center gap-2">
                        <a href="{{ url('/landing') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-400 hover:bg-slate-800 hover:text-emerald-400 transition-colors relative group" title="Keranjang">
                            <i class="fa-solid fa-shopping-cart text-lg"></i>
                            <span id="cartCount" class="absolute 0 top-0 right-0 w-4 h-4 bg-emerald-500 text-white text-[9px] font-bold flex items-center justify-center rounded-full border-2 border-slate-900 group-hover:border-slate-800 transition-colors">@auth{{ \App\Models\Cart::where('user_id',Auth::id())->sum('quantity') }}@else 0 @endauth</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Alerts -->
    @if(session('success'))
    <div class="fixed top-24 right-6 z-50 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-5 py-4 rounded-2xl shadow-lg shadow-emerald-500/10 flex items-start gap-3 max-w-sm" id="alert-success">
        <i class="fa-solid fa-circle-check mt-0.5 text-lg"></i>
        <div class="flex-1 text-sm font-medium">{{ session('success') }}</div>
        <button onclick="document.getElementById('alert-success').remove()" class="text-emerald-400/50 hover:text-emerald-400"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif
    @if(session('error'))
    <div class="fixed top-24 right-6 z-50 bg-rose-500/10 border border-rose-500/20 text-rose-400 px-5 py-4 rounded-2xl shadow-lg shadow-rose-500/10 flex items-start gap-3 max-w-sm" id="alert-error">
        <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
        <div class="flex-1 text-sm font-medium">{{ session('error') }}</div>
        <button onclick="document.getElementById('alert-error').remove()" class="text-rose-400/50 hover:text-rose-400"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 pt-16 pb-8 border-t border-slate-800/50 mt-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 mb-12">
                <!-- Col 1 -->
                <div>
                    <a href="{{ route('home') }}" class="text-3xl font-bold tracking-tighter text-white block mb-4">
                        SAL<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-emerald-400">ZA</span>
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6">SALZA adalah platform jual beli sepatu premium secara online dengan kualitas terjamin, koleksi terlengkap, dan harga terbaik di kelasnya.</p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-purple-400 hover:border-purple-500/30 transition-all"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-blue-400 hover:border-blue-500/30 transition-all"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-emerald-400 hover:border-emerald-500/30 transition-all"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-500 transition-all"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Col 2 -->
                <div>
                    <h4 class="text-white font-bold mb-5 flex items-center"><i class="fa-solid fa-link text-purple-400 mr-2 text-sm"></i> Tautan Singkat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-400 hover:text-purple-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Tentang Kami</a></li>
                        <li><a href="{{ route('shop') }}" class="text-sm text-slate-400 hover:text-purple-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Semua Produk</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-purple-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Promo Spesial</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-purple-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <h4 class="text-white font-bold mb-5 flex items-center"><i class="fa-solid fa-headset text-emerald-400 mr-2 text-sm"></i> Layanan</h4>
                    <ul class="space-y-3">
                        @auth
                            <li><a href="{{ route('order.index') }}" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Pesanan Saya</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Akun Saya</a></li>
                        @endauth
                        <li><button onclick="openTrack()" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Lacak Pesanan</button></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> Garansi & Pengembalian</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-emerald-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right text-[10px] mr-2"></i> FAQ</a></li>
                    </ul>
                </div>

                <!-- Col 4 -->
                <div>
                    <h4 class="text-white font-bold mb-5 flex items-center"><i class="fa-solid fa-location-dot text-amber-400 mr-2 text-sm"></i> Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center flex-shrink-0 text-slate-400 mr-3"><i class="fa-solid fa-map-marker-alt"></i></div>
                            <span class="text-sm text-slate-400 leading-relaxed">Jl. Babakan Tiga No. 82,<br>Ciwidey, Bandung, Jawa Barat</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center flex-shrink-0 text-slate-400 mr-3"><i class="fa-brands fa-whatsapp"></i></div>
                            <span class="text-sm text-slate-400">+62 815 6397 7109</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center flex-shrink-0 text-slate-400 mr-3"><i class="fa-regular fa-envelope"></i></div>
                            <span class="text-sm text-slate-400">esalza@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} SALZA. All Rights Reserved.</p>
                <div class="flex gap-2">
                    <div class="w-8 h-5 bg-slate-800 rounded border border-slate-700 flex items-center justify-center text-[10px] text-slate-400 font-bold">BCA</div>
                    <div class="w-8 h-5 bg-slate-800 rounded border border-slate-700 flex items-center justify-center text-[10px] text-slate-400 font-bold">BNI</div>
                    <div class="w-8 h-5 bg-slate-800 rounded border border-slate-700 flex items-center justify-center text-[10px] text-slate-400 font-bold">OVO</div>
                    <div class="w-8 h-5 bg-slate-800 rounded border border-slate-700 flex items-center justify-center text-[10px] text-slate-400 font-bold">QRIS</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Track Order Modal -->
    <div id="trackOverlay" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="bg-slate-800 border border-slate-700/50 rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300" id="trackModal">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white flex items-center"><i class="fa-solid fa-truck-fast text-purple-400 mr-3"></i> Lacak Pesanan</h3>
                <button onclick="closeTrack()" class="w-8 h-8 rounded-full bg-slate-700/50 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition-colors"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <p class="text-sm text-slate-400 mb-4">Masukkan nomor Invoice Anda untuk melihat status pesanan terkini.</p>
            
            <div class="relative mb-5">
                <i class="fa-solid fa-file-invoice absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                <input type="text" id="invoiceInput" placeholder="Contoh: INV-ABCD1234XY" class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-11 pr-4 text-sm text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all">
            </div>
            
            <button onclick="trackOrder()" id="btnTrack" class="w-full py-3 bg-purple-600 hover:bg-purple-500 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-purple-500/25 flex items-center justify-center gap-2">
                <i class="fa-solid fa-search"></i> Cari Pesanan
            </button>
            
            <div id="trackResult" class="mt-6 hidden"></div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <script>
    window.csrfToken = '{{ csrf_token() }}';
    
    // Modal Track Order
    const trackOverlay = document.getElementById('trackOverlay');
    const trackModal = document.getElementById('trackModal');
    
    function openTrack() {
        trackOverlay.classList.remove('hidden');
        trackOverlay.classList.add('flex');
        // Small delay for animation
        setTimeout(() => {
            trackOverlay.classList.remove('opacity-0');
            trackModal.classList.remove('scale-95');
            trackModal.classList.add('scale-100');
        }, 10);
    }
    
    function closeTrack() {
        trackOverlay.classList.add('opacity-0');
        trackModal.classList.remove('scale-100');
        trackModal.classList.add('scale-95');
        setTimeout(() => {
            trackOverlay.classList.add('hidden');
            trackOverlay.classList.remove('flex');
            document.getElementById('trackResult').classList.add('hidden');
            document.getElementById('invoiceInput').value = '';
        }, 300);
    }
    
    trackOverlay.addEventListener('click', (e) => {
        if (e.target === trackOverlay) closeTrack();
    });

    async function trackOrder() {
        const inv = document.getElementById('invoiceInput').value.trim();
        if (!inv) { showToast('Masukkan nomor invoice!', 'error'); return; }
        
        const btn = document.getElementById('btnTrack');
        const ogText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mencari...';
        btn.disabled = true;

        try {
            const res = await fetch('{{ route("order.track") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                body: JSON.stringify({ invoice: inv })
            });
            const data = await res.json();
            
            const el = document.getElementById('trackResult');
            el.classList.remove('hidden');
            
            if (data.found) {
                el.innerHTML = `
                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                            <span class="text-xs text-slate-500 uppercase tracking-wider">Invoice</span>
                            <span class="text-sm font-bold text-white">${data.invoice}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-500 uppercase tracking-wider">Status</span>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">${data.status}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-500 uppercase tracking-wider">Tanggal</span>
                            <span class="text-sm font-medium text-slate-300">${data.date}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-800">
                            <span class="text-xs text-slate-500 uppercase tracking-wider">Total</span>
                            <span class="text-sm font-bold text-emerald-400">${data.total}</span>
                        </div>
                    </div>`;
            } else {
                el.innerHTML = `<div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-3"><i class="fa-solid fa-circle-xmark"></i> ${data.message}</div>`;
            }
        } catch (error) {
            showToast('Terjadi kesalahan jaringan', 'error');
        } finally {
            btn.innerHTML = ogText;
            btn.disabled = false;
        }
    }

    // Toast Notification System
    function showToast(msg, type = 'success') {
        const c = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        const isSuccess = type === 'success';
        
        toast.className = `transform transition-all duration-300 translate-y-full opacity-0 pointer-events-auto flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl min-w-[280px] border ${
            isSuccess ? 'bg-slate-800 border-emerald-500/30' : 'bg-slate-800 border-rose-500/30'
        }`;
        
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${isSuccess ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400'}">
                <i class="fa-solid ${isSuccess ? 'fa-check' : 'fa-xmark'}"></i>
            </div>
            <span class="text-sm font-semibold text-white flex-1">${msg}</span>
            <button onclick="this.parentElement.remove()" class="text-slate-500 hover:text-white transition-colors"><i class="fa-solid fa-xmark"></i></button>
        `;
        
        c.appendChild(toast);
        
        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-full', 'opacity-0');
        });
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // Cart & Wishlist Actions
    async function addToCart(productId, size = '', color = '', qty = 1) {
        @auth
        try {
            const res = await fetch('{{ route("api.keranjang.tambah") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                body: JSON.stringify({ product_id: productId, quantity: qty, size, color })
            });
            const data = await res.json();
            if (data.success) { 
                document.getElementById('cartCount').textContent = data.count; 
                showToast(data.message, 'success'); 
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
            }
        } catch (e) {
            showToast('Terjadi kesalahan jaringan', 'error');
        }
        @else
        window.location.href = '{{ route("login") }}';
        @endauth
    }



    // Auto-remove standard alerts
    setTimeout(() => {
        const a1 = document.getElementById('alert-success');
        const a2 = document.getElementById('alert-error');
        if(a1) { a1.style.opacity = '0'; setTimeout(()=>a1.remove(),300); }
        if(a2) { a2.style.opacity = '0'; setTimeout(()=>a2.remove(),300); }
    }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
