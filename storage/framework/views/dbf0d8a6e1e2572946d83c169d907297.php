<?php
    $paymentMethods = \App\Models\PaymentMethod::all()->keyBy('code');
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALZA - Marketplace Sepatu UMKM</title>
    <link rel="icon" href="<?php echo e(asset('image/waku.jpeg')); ?>?v=1.0.1" type="image/jpeg">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans:['Inter','sans-serif'], display:['Playfair Display','serif'] },
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-dashboard-card{background:#1e293b}
        .glass-nav{background:rgba(15,23,42,.85);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px)}
        .hero-glow{background:radial-gradient(ellipse at 70% 50%,rgba(16,185,129,.15) 0%,transparent 60%)}
        .card-hover{transition:all .4s cubic-bezier(.4,0,.2,1)}
        .card-hover:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.3),0 0 0 1px rgba(16,185,129,.2)}
        .img-zoom img{transition:transform .6s cubic-bezier(.4,0,.2,1)}
        .img-zoom:hover img{transform:scale(1.08)}
        .fade-up{opacity:0;transform:translateY(30px);transition:all .7s cubic-bezier(.4,0,.2,1)}
        .fade-up.visible{opacity:1;transform:translateY(0)}
        .toast-enter{animation:toastIn .4s ease-out forwards}
        .toast-exit{animation:toastOut .3s ease-in forwards}
        @keyframes toastIn{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}
        @keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100px)}}
        @keyframes float{0%,100%{transform:translateY(0) rotate(-5deg)}50%{transform:translateY(-20px) rotate(-5deg)}}
        .float-anim{animation:float 6s ease-in-out infinite}
        @keyframes pulse-ring{0%{transform:scale(1);opacity:.5}100%{transform:scale(1.5);opacity:0}}
        .pulse-ring::before{content:'';position:absolute;inset:-4px;border-radius:50%;border:2px solid #10b981;animation:pulse-ring 2s ease-out infinite}
        .scrollbar-hide::-webkit-scrollbar{display:none}
        .scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none}
        input:focus,select:focus,textarea:focus{outline:none}
        .line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .auth-tab{position:relative}
        .auth-tab.active{color:#34d399}
        .auth-tab.active::after{content:'';position:absolute;bottom:-1px;left:0;right:0;height:2px;background:#10b981;border-radius:2px}
        @keyframes slideUp {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-bounce-subtle {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards, bounceSubtle 4s ease-in-out infinite 0.6s;
        }
    </style>
</head>
<body class="font-sans text-white antialiased" style="background:#0f172a">

    
    <?php if(session('success')): ?>
    <div id="flash-msg" class="fixed top-24 right-4 z-[80] flex items-center gap-3 px-5 py-4 bg-slate-800 border border-brand-500/30 rounded-xl shadow-2xl max-w-sm toast-enter">
        <i class="fa-solid fa-circle-check text-brand-400 text-lg flex-shrink-0"></i>
        <p class="text-sm text-slate-200"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    
    <nav id="navbar" class="glass-nav fixed top-0 left-0 right-0 z-50 border-b border-slate-700/30 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="<?php echo e(route('front.home')); ?>" class="flex items-center gap-2">
                    <img src="<?php echo e(asset('image/waku.jpeg')); ?>" class="w-9 h-9 rounded-lg object-cover" alt="SALZA Logo">
                    <span class="text-xl font-bold tracking-tight">SALZA</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Beranda</a>
                    <a href="#produk" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Produk</a>
                    <a href="#tentang" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Tentang</a>
                    <a href="#cara-pesan" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Cara Pesan</a>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button onclick="openWishlist()" class="relative w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all" title="Wishlist">
                        <i class="fa-solid fa-heart"></i>
                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $wishlistCount = auth()->user()->wishlists()->count();
                            ?>
                            <span id="wishlist-badge" class="<?php echo e($wishlistCount > 0 ? '' : 'hidden'); ?> absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                <?php echo e($wishlistCount); ?>

                            </span>
                        <?php else: ?>
                            <span id="wishlist-badge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">0</span>
                        <?php endif; ?>
                    </button>
                    <button onclick="openCart()" class="relative w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span id="cart-badge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-brand-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">0</span>
                    </button>
                    <?php if(auth()->guard()->guest()): ?>
                    <button onclick="openAuthModal('login')" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk
                    </button>
                    <?php endif; ?>
                    <?php if(auth()->guard()->check()): ?>
                    <button onclick="openAccount('pesanan')" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fa-solid fa-box text-xs"></i> Pesanan
                    </button>
                    <div class="hidden sm:block relative" id="dd-wrap">
                        <button onclick="document.getElementById('dd-menu').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-700/50 transition-all">
                            <div class="w-8 h-8 bg-brand-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-user text-brand-400 text-xs"></i></div>
                            <span id="nav-user-name" class="text-sm text-slate-300 max-w-[100px] truncate"><?php echo e(auth()->user()->name); ?></span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
                        </button>
                        <div id="dd-menu" class="hidden absolute right-0 top-full mt-2 w-56 bg-slate-800 border border-slate-700/30 rounded-xl shadow-2xl overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-slate-700/30">
                                <p id="dd-user-name" class="text-sm font-semibold text-white"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e(auth()->user()->email); ?></p>
                            </div>
                            <div class="py-1">
                                <button onclick="openAccount('dashboard')" class="flex items-center gap-3 w-full px-4 py-2.5 text-left text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-gauge w-4 text-center text-slate-500"></i>Dashboard Saya</button>
                                <button onclick="openAccount('pesanan')" class="flex items-center gap-3 w-full px-4 py-2.5 text-left text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-box w-4 text-center text-slate-500"></i>Pesanan Saya</button>
                                <button onclick="openAccount('wishlist')" class="flex items-center gap-3 w-full px-4 py-2.5 text-left text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-heart w-4 text-center text-slate-500"></i>Wishlist Saya</button>
                                <button onclick="openAccount('profil')" class="flex items-center gap-3 w-full px-4 py-2.5 text-left text-sm text-slate-300 hover:bg-slate-700/50"><i class="fa-solid fa-user-gear w-4 text-center text-slate-500"></i>Edit Profil</button>
                            </div>
                            <div class="border-t border-slate-700/30 py-1">
                                <form method="POST" action="<?php echo e(route('logout')); ?>" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-left text-sm text-rose-400 hover:bg-rose-500/10"><i class="fa-solid fa-right-from-bracket w-4 text-center"></i>Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all"><i id="mob-icon" class="fa-solid fa-bars"></i></button>
                </div>
            </div>
        </div>
        <div id="search-bar" class="hidden border-t border-slate-700/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input id="search-input" type="text" placeholder="Cari sepatu..." class="w-full pl-11 pr-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all" oninput="filterProducts()">
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-700/30">
            <div class="px-4 py-4 space-y-1">
                <a href="#beranda" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Beranda</a>
                <a href="#produk" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Produk</a>
                <a href="#tentang" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Tentang</a>
                <a href="#cara-pesan" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg">Cara Pesan</a>
                <?php if(auth()->guard()->guest()): ?>
                <button onclick="openAuthModal('login');toggleMobileMenu();" class="block w-full text-left px-4 py-3 text-sm font-medium text-brand-400 hover:bg-brand-500/10 rounded-lg"><i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk / Daftar</button>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                <button onclick="toggleMobileMenu(); openAccount('pesanan')" class="block w-full text-left px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700/50 rounded-lg"><i class="fa-solid fa-box mr-2"></i>Pesanan Saya</button>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="block" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-rose-400 hover:bg-rose-500/10 rounded-lg"><i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <section id="beranda" class="relative min-h-screen flex items-center pt-20 hero-glow overflow-hidden">
        <div class="absolute top-32 right-10 w-72 h-72 bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-56 h-56 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="fade-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500/10 border border-brand-500/20 rounded-full mb-6">
                        <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
                        <span class="text-brand-400 text-xs font-semibold tracking-wide uppercase">Marketplace UMKM Sepatu</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.1] tracking-tight mb-6">Langkahmu,<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 via-brand-400 to-brand-500">Ceritamu.</span></h1>
                    <p class="text-lg text-slate-400 leading-relaxed mb-8 max-w-lg">Temukan koleksi sepatu terbaik dari pengrajin lokal Indonesia. Kualitas premium, harga bersahabat.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#produk" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/25 transition-all duration-300">Jelajahi Produk <i class="fa-solid fa-arrow-right text-sm"></i></a>
                        <a href="#cara-pesan" class="inline-flex items-center gap-2 px-8 py-4 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-medium rounded-xl transition-all"><i class="fa-solid fa-circle-play text-brand-400"></i> Cara Pesan</a>
                    </div>
                    <div class="flex gap-8 mt-10 pt-8 border-t border-slate-700/30">
                        <div><p class="text-2xl font-bold text-white">500+</p><p class="text-sm text-slate-500">Produk Sepatu</p></div>
                        <div><p class="text-2xl font-bold text-white">50+</p><p class="text-sm text-slate-500">UMKM Mitra</p></div>
                        <div><p class="text-2xl font-bold text-white">10K+</p><p class="text-sm text-slate-500">Pelanggan Puas</p></div>
                    </div>
                </div>
                <div class="relative fade-up hidden lg:block">
                    <div class="relative z-10 float-anim">
                        <img src="<?php echo e(asset('images/default-product.png')); ?>" alt="Sepatu Premium" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl shadow-black/30">
                    </div>
                    <div class="absolute top-8 -left-4 bg-dashboard-card border border-slate-700/30 rounded-2xl p-4 shadow-xl z-20 animate-bounce" style="animation-duration:3s">
                        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-brand-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-truck-fast text-brand-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Gratis Ongkir</p><p class="text-xs text-slate-500">Min. belanja 200rb</p></div></div>
                    </div>
                    <div class="absolute bottom-16 -right-4 bg-dashboard-card border border-slate-700/30 rounded-2xl p-4 shadow-xl z-20 animate-bounce" style="animation-duration:4s;animation-delay:1s">
                        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-amber-500/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-shield-halved text-amber-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Garansi Original</p><p class="text-xs text-slate-500">100% produk lokal</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2" id="category-filter">
                <button onclick="setCategory('semua')" data-cat="semua" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-brand-500 text-white shadow-lg shadow-brand-500/20">
                    <i class="fa-solid fa-tags mr-2 text-xs"></i>Semua
                </button>
                <?php $__currentLoopData = $kategori ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button onclick="setCategory('<?php echo e($kat->id); ?>')" data-cat="<?php echo e($kat->id); ?>" class="cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-slate-800 text-slate-400 border border-slate-700/30 hover:border-brand-500/50 hover:text-white">
                    <i class="fa-solid fa-tag mr-2 text-xs"></i><?php echo e($kat->name); ?>

                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="produk" class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Koleksi Terbaru</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-4">Produk Pilihan UMKM</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Sepatu berkualitas dari pengrajin lokal Indonesia.</p>
            </div>
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php $__currentLoopData = $produk ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('front.partials.product_card', ['p' => $p], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if(isset($produk) && count($produk) >= 12): ?>
            <div class="text-center mt-12" id="load-more-container">
                <button onclick="loadMoreProducts()" id="btn-load-more" class="inline-flex items-center gap-2.5 px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-xl border border-slate-700/50 hover:border-brand-500/50 transition-all shadow-lg hover:-translate-y-0.5">
                    <i class="fa-solid fa-spinner animate-spin hidden" id="spinner-load-more"></i>
                    <span>Muat Lebih Banyak</span>
                </button>
            </div>
            <?php endif; ?>
            <div id="empty-state" class="hidden text-center py-20">
    <i class="fa-solid fa-box-open text-5xl text-slate-700 mb-4"></i>
    <p class="text-slate-500 text-lg">Produk tidak ditemukan.</p>
    <button onclick="document.getElementById('search-input').value=''; setCategory('<?php echo e($kategori->first()->id ?? ""); ?>');" class="mt-4 text-brand-400 hover:text-brand-300 text-sm font-medium">Reset Filter</button> 
</div>
    </section>

    
    <section id="tentang" class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative fade-up">
                    <img src="<?php echo e(asset('images/default-product.png')); ?>" alt="Workshop" class="w-full rounded-2xl shadow-xl">
                    <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl p-6 shadow-xl"><p class="text-3xl font-bold text-white">5+</p><p class="text-sm text-brand-100">Tahun Melayani</p></div>
                </div>
                <div class="fade-up">
                    <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-6">Mengangkat Sepatu Lokal ke Panggung Nasional</h2>
                    <p class="text-slate-400 leading-relaxed mb-6">SALZA hadir sebagai jembatan antara pengrajin sepatu UMKM dan pecinta sepatu tanah air.</p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-brand-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-hand-holding-heart text-brand-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">100% Lokal</p><p class="text-xs text-slate-500 mt-1">Produksi dalam negeri</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-medal text-blue-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Quality Control</p><p class="text-xs text-slate-500 mt-1">Standar mutu ketat</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-tags text-amber-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Harga Adil</p><p class="text-xs text-slate-500 mt-1">Langsung dari produsen</p></div></div>
                        <div class="flex items-start gap-3"><div class="w-10 h-10 bg-rose-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-headset text-rose-400 text-sm"></i></div><div><p class="text-sm font-semibold text-white">Support 24/7</p><p class="text-xs text-slate-500 mt-1">Selalu siap membantu</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section id="cara-pesan" class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-brand-400 text-xs font-bold tracking-[0.2em] uppercase">Mudah & Cepat</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 mb-4">Cara Pemesanan</h2>
                <p class="text-slate-400 max-w-xl mx-auto">4 langkah mudah untuk berbelanja sepatu premium di SALZA.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="relative text-center fade-up group">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-brand-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-magnifying-glass text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-brand-400 text-xs font-bold rounded-full leading-7 mb-3">1</span>
                    <h3 class="text-base font-semibold text-white mb-2">Pilih Produk</h3>
                    <p class="text-sm text-slate-500">Jelajahi koleksi sepatu lokal premium dan tentukan pilihan terbaikmu.</p>
                </div>
                <div class="relative text-center fade-up group" style="transition-delay:.1s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-bag-shopping text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-blue-400 text-xs font-bold rounded-full leading-7 mb-3">2</span>
                    <h3 class="text-base font-semibold text-white mb-2">Masukkan Keranjang</h3>
                    <p class="text-sm text-slate-500">Pilih ukuran, warna, dan masukkan produk ke keranjang belanja.</p>
                </div>
                <div class="relative text-center fade-up group" style="transition-delay:.2s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-credit-card text-white text-xl"></i></div>
                    <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-slate-700/50"></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-amber-400 text-xs font-bold rounded-full leading-7 mb-3">3</span>
                    <h3 class="text-base font-semibold text-white mb-2">Checkout & Bayar</h3>
                    <p class="text-sm text-slate-500">Isi alamat, pilih kurir, dan bayar aman dengan COD, Transfer, atau QRIS.</p>
                </div>
                <div class="text-center fade-up group" style="transition-delay:.3s">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-rose-500 to-rose-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform duration-300"><i class="fa-solid fa-truck-fast text-white text-xl"></i></div>
                    <span class="inline-block w-7 h-7 bg-slate-800 text-rose-400 text-xs font-bold rounded-full leading-7 mb-3">4</span>
                    <h3 class="text-base font-semibold text-white mb-2">Konfirmasi & Kirim</h3>
                    <p class="text-sm text-slate-500">Admin mengonfirmasi pesanan, memotong stok, dan langsung mengirimkan paketmu.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 lg:py-24 border-t border-slate-700/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-brand-600 to-brand-800 rounded-3xl p-10 md:p-16 text-center overflow-hidden fade-up">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Tampil Beda?</h2>
                    <p class="text-brand-100 max-w-xl mx-auto mb-8">Bergabunglah dengan ribuan pelanggan yang sudah mempercayakan kebutuhan sepatu mereka melalui SALZA.</p>
                    <a href="#produk" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition-colors shadow-xl">Belanja Sekarang <i class="fa-solid fa-arrow-right text-sm"></i></a>
                </div>
            </div>
        </div>
    </section>

    
    <footer class="border-t border-slate-700/20 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="<?php echo e(asset('image/waku.jpeg')); ?>" class="w-9 h-9 rounded-lg object-cover" alt="SALZA Logo">
                        <span class="text-xl font-bold tracking-tight">SALZA</span>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">Marketplace sepatu UMKM terpercaya.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-brand-500/20 rounded-lg flex items-center justify-center text-slate-500 hover:text-brand-400 transition-all"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                    </div>
                </div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigasi</h4><ul class="space-y-3"><li><a href="#beranda" class="text-sm text-slate-500 hover:text-brand-400">Beranda</a></li><li><a href="#produk" class="text-sm text-slate-500 hover:text-brand-400">Produk</a></li><li><a href="#tentang" class="text-sm text-slate-500 hover:text-brand-400">Tentang</a></li></ul></div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kategori</h4><ul class="space-y-3"><?php $__currentLoopData = $kategori ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a href="#" onclick="setCategory('<?php echo e($kat->slug); ?>');document.getElementById('produk').scrollIntoView({behavior:'smooth'});return false;" class="text-sm text-slate-500 hover:text-brand-400"><?php echo e($kat->name); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
                <div><h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kontak</h4><ul class="space-y-3"><li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-slate-600 mt-0.5 text-sm"></i><span class="text-sm text-slate-500">Jl. Pengrajin No. 45, Bandung</span></li><li class="flex items-center gap-3"><i class="fa-solid fa-phone text-slate-600 text-sm"></i><span class="text-sm text-slate-500">+62 812-3456-7890</span></li><li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-slate-600 text-sm"></i><span class="text-sm text-slate-500">hello@salza.id</span></li></ul></div>
            </div>
            <div class="border-t border-slate-700/30 pt-8 text-center"><p class="text-xs text-slate-600">&copy; <?php echo e(date('Y')); ?> SALZA. All rights reserved.</p></div>
        </div>
    </footer>

    
    <div id="cart-overlay" class="fixed inset-0 bg-black/60 z-50 hidden opacity-0 transition-opacity duration-300" onclick="closeCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 bottom-0 w-full max-w-md bg-slate-900 border-l border-slate-700/30 z-50 transform translate-x-full transition-transform duration-300 flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-slate-700/30 flex-shrink-0">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2"><i class="fa-solid fa-bag-shopping text-brand-400"></i> Keranjang</h3>
            <button onclick="closeCart()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <div id="cart-select-all-container" class="px-6 py-3 border-b border-slate-800 bg-slate-950/20 flex items-center justify-between hidden flex-shrink-0">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" id="cart-select-all" class="rounded border-slate-700 text-brand-500 focus:ring-brand-500/20 bg-slate-800 w-4 h-4 transition-colors" onchange="toggleSelectAllCartItems(this.checked)">
                <span class="text-xs text-slate-400 font-semibold select-none">Pilih Semua</span>
            </label>
        </div>
        <div id="cart-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <div id="cart-empty" class="flex flex-col items-center justify-center h-full text-center"><i class="fa-solid fa-bag-shopping text-5xl text-slate-700 mb-4"></i><p class="text-slate-500">Keranjang masih kosong</p></div>
        </div>
        <div id="cart-footer" class="hidden border-t border-slate-700/30 p-6 space-y-3 flex-shrink-0">
            <?php if(auth()->guard()->guest()): ?>
            <div class="bg-brand-500/10 border border-brand-500/20 rounded-xl p-3 flex items-center gap-3"><i class="fa-solid fa-circle-info text-brand-400"></i><p class="text-xs text-brand-300">Login/daftar dulu untuk checkout</p></div>
            <?php endif; ?>
            <div class="flex justify-between text-sm"><span class="text-slate-400">Subtotal</span><span id="cart-subtotal" class="text-white font-semibold">Rp 0</span></div>
            <button onclick="handleCheckoutClick()" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all"><i class="fa-solid fa-lock mr-2 text-xs"></i>Checkout</button>
        </div>
    </div>

    
    <?php if(auth()->guard()->check()): ?>
    <div id="account-overlay" class="fixed inset-0 bg-black/60 z-50 hidden opacity-0 transition-opacity duration-300" onclick="closeAccount()"></div>
    <div id="account-sidebar" class="fixed top-0 right-0 bottom-0 w-full max-w-xl bg-slate-900 border-l border-slate-700/30 z-50 transform translate-x-full transition-transform duration-300 flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-slate-700/30 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-500/15 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-user-gear text-brand-400 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Akun Saya</h3>
                    <p class="text-xs text-slate-500">Kelola pesanan dan profil Anda</p>
                </div>
            </div>
            <button onclick="closeAccount()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        
        
        <div class="flex border-b border-slate-800 scrollbar-hide overflow-x-auto flex-shrink-0">
            <button onclick="switchAccountTab('dashboard')" id="btn-acc-dashboard" class="flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-brand-500 text-brand-400 transition-all">Dashboard</button>
            <button onclick="switchAccountTab('pesanan')" id="btn-acc-pesanan" class="flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-transparent text-slate-400 hover:text-white transition-all">Pesanan Saya</button>
            <button onclick="switchAccountTab('profil')" id="btn-acc-profil" class="flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-transparent text-slate-400 hover:text-white transition-all">Edit Profil</button>
            
            
            <button onclick="switchAccountTab('wishlist')" id="btn-acc-wishlist" class="flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-transparent text-slate-400 hover:text-white transition-all">Wishlist</button>
        </div>

        
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <div id="tab-acc-content-dashboard" class="space-y-6">
                <?php
                    $unpaidOrders = collect($orders ?? [])->filter(fn($o) => $o->payment_status === 'unpaid' && $o->status === 'menunggu');
                ?>
                <?php if($unpaidOrders->isNotEmpty()): ?>
                <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-start gap-3 text-amber-400 text-xs leading-relaxed">
                    <i class="fa-solid fa-circle-exclamation text-base mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-bold text-white mb-0.5">Peringatan Pembayaran</p>
                        <p class="text-slate-300">Anda memiliki <?php echo e($unpaidOrders->count()); ?> pesanan yang belum dibayar. Silakan lakukan pembayaran dan unggah bukti pembayaran agar pesanan Anda dapat segera diproses.</p>
                        <button onclick="switchAccountTab('pesanan')" class="mt-2 text-amber-400 font-bold hover:underline flex items-center gap-1">Bayar Sekarang <i class="fa-solid fa-arrow-right text-[10px]"></i></button>
                    </div>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-800/40 border border-slate-700/20 rounded-2xl p-5 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-400 text-xl"><i class="fa-solid fa-box"></i></div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Total Pesanan</p>
                            <p class="text-2xl font-bold text-white mt-0.5"><?php echo e(count($orders ?? [])); ?></p>
                        </div>
                    </div>
                    <?php
                        $activeStatuses = ['pending', 'unpaid', 'menunggu', 'menunggu_pembayaran', 'menunggu_konfirmasi', 'dikonfirmasi', 'dikemas', 'dikirim', 'diperjalanan'];
                        $totalActive = 0;
                        if (isset($orders)) {
                            foreach($orders as $o) {
                                if (in_array(strtolower($o->status), $activeStatuses)) {
                                    $totalActive++;
                                }
                            }
                        }
                    ?>
                    <div class="bg-slate-800/40 border border-slate-700/20 rounded-2xl p-5 flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 text-xl"><i class="fa-solid fa-truck-fast"></i></div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Pesanan Aktif</p>
                            <p class="text-2xl font-bold text-white mt-0.5"><?php echo e($totalActive); ?></p>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2 mb-1"><i class="fa-solid fa-clock-rotate-left text-slate-500"></i> Pesanan Terakhir</h4>
                    <?php if(isset($orders) && count($orders) > 0): ?>
                        <?php $__currentLoopData = collect($orders)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-slate-800/30 border border-slate-800 rounded-xl p-4 flex justify-between items-center text-sm">
                            <div>
                                <p class="text-xs text-brand-400 font-semibold uppercase tracking-wider"><?php echo e($order->invoice); ?></p>
                                <p class="text-xs text-slate-500 mt-0.5"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
                                <p class="text-sm font-bold text-white mt-1">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                            </div>
                            <div class="text-right">
                                <?php if($order->payment_status === 'unpaid'): ?>
                                    <span class="px-2.5 py-1 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 text-[10px] font-bold uppercase tracking-wider block mb-2">Menunggu Pembayaran</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-lg bg-brand-500/10 text-brand-400 text-[10px] font-bold uppercase tracking-wider block mb-2"><?php echo e(str_replace('_', ' ', $order->status)); ?></span>
                                <?php endif; ?>
                                <button onclick="switchAccountTab('pesanan')" class="text-xs text-slate-400 hover:text-white font-medium underline">Lihat Semua</button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-6 bg-slate-800/20 border border-slate-800/40 rounded-2xl">
                            <p class="text-xs text-slate-500">Belum ada transaksi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div id="tab-acc-content-pesanan" class="space-y-4 hidden">
                <?php if(isset($orders) && count($orders) > 0): ?>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-slate-800/40 border border-slate-700/20 rounded-2xl p-5 space-y-4">
                        <div class="flex justify-between items-start border-b border-slate-800 pb-3">
                            <div>
                                <p class="text-xs text-brand-400 font-bold uppercase tracking-wider"><?php echo e($order->invoice); ?></p>
                                <p class="text-xs text-slate-500 mt-0.5"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
                            </div>
                            <?php if($order->payment_status === 'unpaid'): ?>
                                <span class="px-2.5 py-1 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 text-[10px] font-bold uppercase tracking-wider">Menunggu Pembayaran</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 rounded-lg bg-brand-500/10 text-brand-400 text-[10px] font-bold uppercase tracking-wider"><?php echo e(str_replace('_', ' ', $order->status)); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="space-y-2">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img src="<?php echo e($item->produk->thumbnail_url ?? asset('images/default-product.png')); ?>" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-medium truncate text-xs"><?php echo e($item->product->name ?? $item->produk->name ?? 'Produk'); ?></p>
                                    <p class="text-[10px] text-slate-500 mt-0.5">Size: <?php echo e($item->size ?? '-'); ?> | Qty: <?php echo e($item->quantity); ?></p>
                                </div>
                                <p class="text-xs font-semibold text-slate-300 flex-shrink-0">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-slate-800 text-xs">
                            <div>
                                <p class="text-slate-500">Total Bayar</p>
                                <p class="text-sm font-bold text-white mt-0.5">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                            </div>
                            <button onclick="openOrderDetail('<?php echo e($order->invoice); ?>')" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition-all border border-slate-700/50">Detail Pesanan</button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fa-solid fa-box-open text-4xl text-slate-700 mb-3"></i>
                        <p class="text-slate-400 font-semibold text-sm">Belum Ada Pesanan</p>
                        <p class="text-xs text-slate-600 mt-1">Ayo mulai belanja sepatu lokal favoritmu!</p>
                        <button onclick="closeAccount(); document.getElementById('produk').scrollIntoView({behavior:'smooth'});" class="mt-4 px-4 py-2 bg-brand-500/10 text-brand-400 hover:bg-brand-500/20 rounded-xl text-xs font-semibold transition-all">Mulai Belanja</button>
                    </div>
                <?php endif; ?>
            </div>

            
            <div id="tab-acc-content-profil" class="space-y-4 hidden">
                <form id="acc-profile-form" onsubmit="submitProfile(event)" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" name="name" required value="<?php echo e(auth()->user()->name); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-700/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wide">Alamat Email (Tidak dapat diubah)</label>
                        <input type="email" disabled value="<?php echo e(auth()->user()->email); ?>" class="w-full px-4 py-3 bg-slate-800/40 border border-slate-800 rounded-xl text-slate-500 text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wide">No. Telepon / WhatsApp</label>
                        <input type="tel" name="phone" value="<?php echo e(auth()->user()->phone ?? ''); ?>" placeholder="081234567890" class="w-full px-4 py-3 bg-slate-800 border border-slate-700/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <button type="submit" id="submit-profile-btn" class="w-full py-3 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl transition-all"><i class="fa-solid fa-save mr-2 text-xs"></i>Simpan Perubahan</button>
                </form>
            </div>

               

            
            <div id="tab-acc-content-wishlist" class="space-y-4 hidden">
                <div id="wishlist-loading" class="text-center py-8 text-slate-500">
                    <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 text-brand-400"></i>
                    <p class="text-xs">Memuat daftar favorit...</p>
                </div>
                <div id="wishlist-empty" class="hidden bg-slate-800/40 border border-slate-700/20 rounded-2xl p-5 text-center py-10">
                    <i class="fa-solid fa-heart-crack text-4xl text-slate-700 mb-3 block"></i>
                    <h5 class="text-sm font-semibold text-white">Wishlist Anda Kosong</h5>
                    <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">Telusuri produk pilihan kami dan simpan produk yang Anda sukai di sini.</p>
                </div>
                <div id="wishlist-items-container" class="space-y-4">
                    <!-- Dynamic wishlist items will be inserted here -->
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div id="auth-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeAuthModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex border-b border-slate-700/30">
                <button onclick="switchAuthTab('login')" id="tab-login" class="auth-tab active flex-1 py-4 text-sm font-semibold text-center transition-colors">Masuk</button>
                <button onclick="switchAuthTab('register')" id="tab-register" class="auth-tab flex-1 py-4 text-sm font-semibold text-center text-slate-500 transition-colors">Daftar</button>
            </div>
            <div id="form-login" class="p-6">
                <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="intended" value="<?php echo e(url()->current()); ?>">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                        <input type="email" name="email" required placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                        <input type="password" name="password" required placeholder="Masukkan password" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <?php if(session('error')): ?>
                    <div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Masuk</button>
                    <p class="text-center text-sm text-slate-500">Belum punya akun? <button type="button" onclick="switchAuthTab('register')" class="text-brand-400 hover:text-brand-300 font-medium">Daftar</button></p>
                </form>
            </div>
            <div id="form-register" class="p-6 hidden">
                <form method="POST" action="<?php echo e(route('daftar')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-rose-400">*</span></label>
                        <input type="text" name="name" required placeholder="Nama lengkap" value="<?php echo e(old('name')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">No. WhatsApp <span class="text-rose-400">*</span></label>
                        <input type="tel" name="whatsapp" required placeholder="081234567890" value="<?php echo e(old('whatsapp')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email <span class="text-rose-400">*</span></label>
                        <input type="email" name="email" required placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-rose-400">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password <span class="text-rose-400">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                    </div>
                    <?php if(session('error')): ?>
                    <div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Daftar Akun</button>
                    <p class="text-center text-sm text-slate-500">Sudah punya akun? <button type="button" onclick="switchAuthTab('login')" class="text-brand-400 hover:text-brand-300 font-medium">Masuk</button></p>
                </form>
            </div>
        </div>
    </div>

    
    <div id="checkout-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeCheckout()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between p-6 border-b border-slate-700/30 sticky top-0 bg-slate-900 z-10 rounded-t-2xl">
                <h3 class="text-lg font-semibold text-white">Checkout</h3>
                <button onclick="closeCheckout()" class="w-10 h-10 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="checkout-form" onsubmit="submitOrder(event)" class="p-6 space-y-5">
                <?php echo csrf_field(); ?>
                <?php if(auth()->guard()->check()): ?>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <h4 class="text-sm font-semibold text-white flex items-center gap-2 mb-3"><i class="fa-solid fa-user text-brand-400 text-xs"></i> Data Pembeli</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-slate-500 text-xs">Nama</p><p class="text-white font-medium"><?php echo e(auth()->user()->name); ?></p></div>
                        <div><p class="text-slate-500 text-xs">WhatsApp</p><p class="text-white font-medium"><?php echo e(auth()->user()->whatsapp ?? auth()->user()->phone ?? '-'); ?></p></div>
                        <div class="col-span-2"><p class="text-slate-500 text-xs">Email</p><p class="text-white font-medium"><?php echo e(auth()->user()->email); ?></p></div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <h4 class="text-sm font-semibold text-white mb-3">Ringkasan Pesanan</h4>
                    <div id="checkout-summary" class="space-y-2 text-sm"></div>
                    <div class="border-t border-slate-700/30 mt-3 pt-3 flex justify-between"><span class="text-white font-semibold">Subtotal</span><span id="checkout-subtotal" class="text-brand-400 font-bold"></span></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Alamat Lengkap <span class="text-rose-400">*</span></label>
                    <textarea name="alamat" required rows="3" placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan, Kota, Kode Pos" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Provinsi <span class="text-rose-400">*</span></label>
                        <select name="provinsi" id="provinsi-select" required onchange="handleProvinceChange()" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <option value="">Pilih Provinsi</option>
                            <?php $__currentLoopData = $provinsi ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>"><?php echo e($v); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kota <span class="text-rose-400">*</span></label>
                        <select name="kota" id="kota-select" required class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <option value="">Pilih Kota</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kurir <span class="text-rose-400">*</span></label>
                        <select name="kurir" id="kurir-select" required onchange="updateShipping()" class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <option value="">Pilih Kurir</option>
                            <?php $__currentLoopData = $kurir ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>"><?php echo e($v); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/20">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-400">Ongkos Kirim</span>
                        <div class="text-right">
                            <span id="checkout-shipping" class="text-white font-medium">Pilih lokasi & kurir</span>
                            <span id="checkout-estimation" class="block text-[10px] text-slate-400 mt-0.5 hidden"></span>
                        </div>
                    </div>
                    <div class="flex justify-between"><span class="text-white font-semibold">Total Bayar</span><span id="checkout-grand-total" class="text-brand-400 font-bold text-lg">-</span></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Metode Pembayaran <span class="text-rose-400">*</span></label>
                    <?php
                        $activePaymentCount = $paymentMethods->where('is_active', true)->count();
                    ?>
                    <?php if($activePaymentCount === 0): ?>
                        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-center text-rose-400 text-xs font-semibold">
                            Maaf, tidak ada metode pembayaran yang aktif saat ini. Hubungi admin.
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-<?php echo e(min(3, $activePaymentCount)); ?> gap-3">
                            <?php if($paymentMethods->get('transfer')?->is_active): ?>
                                <label class="flex flex-col items-center justify-center text-center gap-2 p-4 bg-slate-800 border border-slate-700/50 rounded-xl cursor-pointer hover:border-brand-500/50 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-500/5 group">
                                    <input type="radio" name="pembayaran" value="transfer" required class="accent-brand-500">
                                    <i class="fa-solid fa-building-columns text-lg text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                                    <span class="text-xs font-semibold text-slate-300">Transfer Bank</span>
                                </label>
                            <?php endif; ?>
                            <?php if($paymentMethods->get('cod')?->is_active): ?>
                                <label class="flex flex-col items-center justify-center text-center gap-2 p-4 bg-slate-800 border border-slate-700/50 rounded-xl cursor-pointer hover:border-brand-500/50 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-500/5 group">
                                    <input type="radio" name="pembayaran" value="cod" required class="accent-brand-500">
                                    <i class="fa-solid fa-hand-holding-dollar text-lg text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                                    <span class="text-xs font-semibold text-slate-300">COD</span>
                                </label>
                            <?php endif; ?>
                            <?php if($paymentMethods->get('ewallet')?->is_active): ?>
                                <label class="flex flex-col items-center justify-center text-center gap-2 p-4 bg-slate-800 border border-slate-700/50 rounded-xl cursor-pointer hover:border-brand-500/50 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-500/5 group">
                                    <input type="radio" name="pembayaran" value="ewallet" required class="accent-brand-500">
                                    <i class="fa-solid fa-wallet text-lg text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                                    <span class="text-xs font-semibold text-slate-300">E-Wallet (QRIS)</span>
                                </label>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Catatan (opsional)</label>
                    <textarea name="catatan" rows="2" placeholder="Catatan tambahan..." class="w-full px-4 py-3 bg-slate-800 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all resize-none"></textarea>
                </div>
                <button type="submit" id="submit-order-btn" class="w-full py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/25 transition-all text-base"><i class="fa-solid fa-paper-plane mr-2"></i>Buat Pesanan</button>
            </form>
        </div>
    </div>

    
    <div id="product-modal" class="fixed inset-0 bg-black/70 z-[55] hidden flex items-center justify-center p-4" onclick="closeProductModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div id="product-modal-content"><div class="flex items-center justify-center h-64"><i class="fa-solid fa-spinner fa-spin text-brand-400 text-2xl"></i></div></div>
        </div>
    </div>

    
    <div id="success-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-sm text-center p-10">
            <div class="w-20 h-20 mx-auto bg-brand-500/20 rounded-full flex items-center justify-center mb-6 relative pulse-ring"><i class="fa-solid fa-check text-brand-400 text-3xl"></i></div>
            <h3 class="text-xl font-bold text-white mb-2">Pesanan Berhasil!</h3>
            <p class="text-sm text-slate-400 mb-2">Silakan cek detail pesanan Anda di menu Pesanan Saya.</p>
            <p class="text-sm text-slate-400 mb-6">Kode: <span id="invoice-number" class="text-brand-400 font-semibold">-</span></p>
            <button onclick="window.location.href = '<?php echo e(route('shop')); ?>?open_account=pesanan'" class="block w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl transition-all mb-3">Lihat Pesanan Saya</button>
            <button onclick="window.location.href = '<?php echo e(route('shop')); ?>'" class="w-full py-3 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-medium rounded-xl transition-all">Tutup</button>
        </div>
    </div>

    
    <div id="order-detail-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeOrderDetailModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="p-6 md:p-8 space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-brand-400"></i> Detail Pesanan
                        </h3>
                        <p class="text-xs text-slate-400 mt-1" id="od-date">-</p>
                    </div>
                    <button onclick="closeOrderDetailModal()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Invoice & Status -->
                <div class="grid grid-cols-2 gap-4 bg-slate-850 p-4 rounded-xl border border-slate-800">
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-bold">No. Invoice</p>
                        <p class="text-sm font-bold text-white mt-1" id="od-invoice">-</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-bold">Status</p>
                        <div class="mt-1" id="od-status-badge">-</div>
                    </div>
                </div>

                <!-- Products -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-box-open text-brand-400"></i> Daftar Produk
                    </h4>
                    <div class="space-y-4 max-h-60 overflow-y-auto pr-2" id="od-products-list">
                        <!-- Dynamic content -->
                    </div>
                </div>

                <!-- Shipping & Payment Grid -->
                <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-slate-800">
                    <!-- Shipping Info -->
                    <div>
                        <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-truck text-brand-400"></i> Informasi Pengiriman
                        </h4>
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 text-xs space-y-2">
                            <p class="text-slate-400"><strong class="text-slate-300">Penerima:</strong> <span id="od-recipient-name">-</span></p>
                            <p class="text-slate-400"><strong class="text-slate-300">Telepon:</strong> <span id="od-recipient-phone">-</span></p>
                            <p class="text-slate-400"><strong class="text-slate-300">Alamat:</strong> <span id="od-recipient-address">-</span></p>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div>
                        <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-wallet text-brand-400"></i> Pembayaran
                        </h4>
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 text-xs space-y-2">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Metode</span>
                                <span class="font-bold text-white uppercase" id="od-payment-method">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Status Bayar</span>
                                <span class="font-bold" id="od-payment-status">-</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-800 pt-2 text-sm mt-2">
                                <span class="font-bold text-slate-300">Total</span>
                                <span class="font-black text-brand-400" id="od-total-pay">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transfer Manual & Proof Upload Section -->
                <div id="od-payment-instructions" class="hidden space-y-4 pt-4 border-t border-slate-800">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-brand-400"></i> <span id="od-payment-instructions-title">Petunjuk Pembayaran</span>
                    </h4>
                    <div class="bg-brand-500/5 border border-brand-500/20 p-4 rounded-xl text-xs text-slate-300">
                        <!-- Box 1: Bank Transfer -->
                        <div id="od-transfer-instructions-box" class="space-y-2">
                            <p>Silakan transfer total pembayaran sebesar <strong class="text-white text-sm" id="od-transfer-amount">Rp -</strong> ke salah satu rekening berikut:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                                    <p class="font-bold text-slate-300 text-brand-400">Bank BCA</p>
                                    <p class="text-white font-mono mt-1 text-sm">123-456-7890</p>
                                    <p class="text-[10px] text-slate-500 mt-0.5">a.n. ShoesMarket</p>
                                </div>
                                <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                                    <p class="font-bold text-slate-300 text-brand-400">Bank Mandiri</p>
                                    <p class="text-white font-mono mt-1 text-sm">987-654-3210</p>
                                    <p class="text-[10px] text-slate-500 mt-0.5">a.n. ShoesMarket</p>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2" id="od-unique-code-container">Catatan: Tiga digit terakhir <strong class="text-white text-brand-400" id="od-transfer-unique-code">(-)</strong> adalah kode unik identifikasi transaksi Anda agar proses verifikasi lebih cepat.</p>
                        </div>

                        <!-- Box 2: E-Wallet QRIS -->
                        <div id="od-ewallet-instructions-box" class="hidden space-y-3">
                            <p>Silakan scan QRIS di bawah ini dengan aplikasi e-wallet Anda (GoPay, OVO, DANA, LinkAja) atau transfer ke nomor e-wallet resmi kami sebesar <strong class="text-white text-sm" id="od-ewallet-amount">Rp -</strong>:</p>
                            <div class="flex flex-col sm:flex-row items-center gap-4 bg-slate-900/60 p-4 rounded-lg border border-slate-800">
                                <div class="w-28 h-28 bg-white p-1.5 rounded-lg flex-shrink-0 flex items-center justify-center">
                                    <img src="/images/qris_mockup.png" alt="QRIS QR Code" class="w-full h-full object-contain">
                                </div>
                                <div class="space-y-2 w-full text-left">
                                    <div class="border-b border-slate-700/30 pb-1.5">
                                        <p class="font-bold text-slate-300 text-brand-400">QRIS All Payment</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Scan & Bayar Instan</p>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-300 text-brand-400">DANA / OVO / GoPay</p>
                                        <p class="text-white font-mono mt-0.5 text-sm">0812-3456-7890</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">a.n. ShoesMarket</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400">Catatan: Setelah melakukan pembayaran via e-wallet, harap ambil tangkapan layar (screenshot) bukti transaksi Anda dan unggah pada form di bawah ini.</p>
                        </div>
                    </div>

                    <!-- Upload Proof Form -->
                    <div class="bg-slate-850 p-4 rounded-xl border border-slate-800 space-y-3">
                        <h5 class="text-xs font-bold text-white flex items-center gap-1.5">
                            <i class="fa-solid fa-cloud-arrow-up text-brand-400"></i> Konfirmasi Pembayaran
                        </h5>
                        
                        <!-- Uploaded Proof Preview/Image -->
                        <div id="od-proof-uploaded-container" class="hidden">
                            <p class="text-[10px] text-slate-400 mb-1.5">Bukti transfer yang telah Anda unggah:</p>
                            <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-slate-750 bg-slate-900 mb-2">
                                <img id="od-proof-uploaded-img" src="" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Upload form/input -->
                        <form id="od-upload-proof-form"  onsubmit="uploadPaymentProof(event)" class="space-y-3">
                            <div>
                                <label class="block text-[11px] text-slate-400 mb-1.5">Pilih file bukti transfer (JPG, PNG, max 3MB):</label>
                                <input type="file" name="bukti" accept="image/*" required class="block w-full text-xs text-slate-450 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-500/10 file:text-brand-400 hover:file:bg-brand-500/20 file:cursor-pointer">
                            </div>
                            <button type="submit" id="od-proof-submit-btn" class="px-4 py-2 bg-brand-500 hover:bg-brand-400 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-brand-500/20 flex items-center gap-1.5">
                                <i class="fa-solid fa-upload"></i> Unggah Bukti Transfer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Ulasan Pesanan Section -->
                <div id="od-review-section" class="hidden space-y-4 pt-4 border-t border-slate-800">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-400"></i> Ulasan Pesanan
                    </h4>
                    
                    <!-- View Mode (Already Reviewed) -->
                    <div id="od-review-view-box" class="hidden bg-slate-850 p-4 rounded-xl border border-slate-800/80 space-y-2">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs text-slate-450">Rating Anda:</span>
                            <div id="od-review-view-stars" class="flex text-amber-400 text-[10px] gap-0.5">
                                <!-- Stars rendered by JS -->
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 italic" id="od-review-view-text">"-"</p>
                    </div>

                    <!-- Form Mode (Not Yet Reviewed) -->
                    <div id="od-review-form-box" class="hidden bg-slate-850 p-4 rounded-xl border border-slate-800 space-y-3">
                        <form id="od-review-form" onsubmit="submitOrderReview(event)" class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-slate-300 font-semibold">Pilih Rating:</span>
                                <div class="flex items-center gap-1" id="star-rating-selector">
                                    <button type="button" onclick="setStarRating(1)" class="text-slate-600 hover:text-amber-400 text-base transition-colors duration-150"><i class="fa-solid fa-star"></i></button>
                                    <button type="button" onclick="setStarRating(2)" class="text-slate-600 hover:text-amber-400 text-base transition-colors duration-150"><i class="fa-solid fa-star"></i></button>
                                    <button type="button" onclick="setStarRating(3)" class="text-slate-600 hover:text-amber-400 text-base transition-colors duration-150"><i class="fa-solid fa-star"></i></button>
                                    <button type="button" onclick="setStarRating(4)" class="text-slate-600 hover:text-amber-400 text-base transition-colors duration-150"><i class="fa-solid fa-star"></i></button>
                                    <button type="button" onclick="setStarRating(5)" class="text-amber-400 text-base transition-colors duration-150"><i class="fa-solid fa-star"></i></button>
                                </div>
                                <input type="hidden" id="review-rating-input" value="5" required>
                            </div>
                            <div>
                                <textarea id="review-text-input" required minlength="5" rows="2" placeholder="Bagikan ulasan Anda mengenai produk dan pelayanan kami..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder:text-slate-600 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all outline-none resize-none"></textarea>
                            </div>
                            <button type="submit" id="review-submit-btn" class="px-4 py-2 bg-brand-500 hover:bg-brand-400 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-brand-500/20 flex items-center gap-1.5">
                                <i class="fa-solid fa-paper-plane"></i> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                    <button id="od-refund-btn" onclick="openRefundModal(this.dataset.orderId)" class="hidden px-4 py-2 bg-rose-500 hover:bg-rose-450 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-rose-500/20 flex items-center gap-1.5">
                        <i class="fa-solid fa-rotate-left"></i> Ajukan Pengembalian
                    </button>
                    <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold rounded-xl transition-all border border-slate-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-print"></i> Cetak Invoice
                    </button>
                    <button onclick="closeOrderDetailModal()" class="px-4 py-2 bg-brand-500 hover:bg-brand-400 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-brand-500/20">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div id="refund-modal" class="fixed inset-0 bg-black/80 z-[65] hidden flex items-center justify-center p-4" onclick="closeRefundModal()">
        <div class="bg-slate-900 border border-slate-700/30 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-scale-up" onclick="event.stopPropagation()">
            <div class="p-6 md:p-8 space-y-5">
                <!-- Header -->
                <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                    <div>
                        <h3 class="text-base font-bold text-white flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left text-rose-500"></i> Pengembalian Uang (Refund)
                        </h3>
                        <p class="text-[10px] text-slate-450 mt-0.5">Lengkapi formulir rekening Anda untuk proses pengembalian dana.</p>
                    </div>
                    <button onclick="closeRefundModal()" class="w-7 h-7 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <!-- Form -->
                <form id="refund-form" onsubmit="submitRefundRequest(event)" class="space-y-4">
                    <input type="hidden" id="refund-order-id">
                    
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-300">Nama Bank / E-Wallet</label>
                        <input type="text" id="refund-bank-name" required placeholder="Contoh: Bank BCA, Mandiri, DANA, GoPay" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder:text-slate-600 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-300">Nomor Rekening / No. HP E-Wallet</label>
                        <input type="text" id="refund-account-number" required placeholder="Masukkan nomor rekening atau nomor HP" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder:text-slate-600 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-300">Nama Pemilik Rekening</label>
                        <input type="text" id="refund-account-name" required placeholder="Nama lengkap pemilik rekening" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder:text-slate-600 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-300">Alasan Pengembalian (Opsional)</label>
                        <textarea id="refund-reason" rows="2" placeholder="Tuliskan alasan pengembalian dana jika ada..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder:text-slate-600 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all outline-none resize-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-2.5 pt-4 border-t border-slate-800">
                        <button type="button" onclick="closeRefundModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold rounded-xl transition-all">
                            Batal
                        </button>
                        <button type="submit" id="refund-submit-btn" class="px-4 py-2 bg-rose-500 hover:bg-rose-450 text-white text-xs font-semibold rounded-xl transition-all shadow-md shadow-rose-500/20 flex items-center gap-1.5">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="toast-container" class="fixed top-24 right-4 z-[70] space-y-3"></div>

    
    <script>
    const APP = {
        csrfToken: '<?php echo e(csrf_token()); ?>',
        isLoggedIn: <?php echo e(auth()->check() ? 'true' : 'false'); ?>,
        paymentMethods: <?php echo json_encode($paymentMethods, 15, 512) ?>,
        routes: {
            keranjangIndex: '<?php echo e(route("api.keranjang")); ?>',
            keranjangTambah: '<?php echo e(route("api.keranjang.tambah")); ?>',
            keranjangHapus: '<?php echo e(route("api.keranjang.hapus", "ID")); ?>',
            keranjangUpdate: '<?php echo e(route("api.keranjang.update", "ID")); ?>',
            produkDetail: '<?php echo e(route("api.produk.detail", "ID")); ?>',
            checkout: '<?php echo e(route("api.checkout")); ?>',
        }
    };

let cart = [], currentCategory = '<?php echo e($kategori->isNotEmpty() ? $kategori->first()->id : "semua"); ?>', shippingCost = 0;
const shippingRates = <?php echo json_encode($ongkirRates ?? [], 15, 512) ?>;

    async function api(url, method = 'GET', data = null) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const opts = { method, headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' } };
        if (method !== 'GET') { opts.headers['Content-Type'] = 'application/json'; opts.headers['X-CSRF-TOKEN'] = token; opts.body = JSON.stringify(data); }
        const res = await fetch(url, opts);
        const json = await res.json();
        if (!res.ok) throw { message: json.message || 'Terjadi kesalahan', errors: json.errors };
        return json;
    }

    function openAuthModal(tab) { switchAuthTab(tab); document.getElementById('auth-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeAuthModal() { document.getElementById('auth-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function switchAuthTab(tab) {
        document.getElementById('form-login').classList.toggle('hidden', tab !== 'login');
        document.getElementById('form-register').classList.toggle('hidden', tab !== 'register');
        document.getElementById('tab-login').classList.toggle('active', tab === 'login');
        document.getElementById('tab-register').classList.toggle('active', tab === 'register');
        document.getElementById('tab-login').classList.toggle('text-slate-500', tab !== 'login');
        document.getElementById('tab-register').classList.toggle('text-slate-500', tab !== 'register');
    }

    let selectedCartIds = [];

    function setCart(newCart) {
        cart = newCart || [];
        const currentIds = cart.map(i => i.id);
        selectedCartIds = selectedCartIds.filter(id => currentIds.includes(id));
        currentIds.forEach(id => {
            if (!selectedCartIds.includes(id)) {
                selectedCartIds.push(id);
            }
        });
        updateCartUI();
    }

    window.toggleSelectCartItem = function(id) {
        id = isNaN(id) ? id : Number(id);
        const idx = selectedCartIds.indexOf(id);
        if (idx > -1) {
            selectedCartIds.splice(idx, 1);
        } else {
            selectedCartIds.push(id);
        }
        updateCartUI();
    }

    window.toggleSelectAllCartItems = function(checked) {
        if (checked) {
            selectedCartIds = cart.map(i => i.id);
        } else {
            selectedCartIds = [];
        }
        updateCartUI();
    }

    async function loadCart() { try { const r = await api(APP.routes.keranjangIndex); setCart(r.data); } catch { setCart([]); } }
    async function quickAddToCart(id, ukuran = null, warna = null, qty = 1) { try { const r = await api(APP.routes.keranjangTambah, 'POST', { produk_id: id, ukuran, warna, qty: qty }); setCart(r.data); showToast(r.message || 'Ditambahkan', 'success'); } catch (e) { showToast(e.message || 'Gagal', 'error'); if (e.message && e.message.toLowerCase().includes('login')) { setTimeout(() => openAuthModal('login'), 800); } } }
    async function removeFromCart(id) { try { const r = await api(APP.routes.keranjangHapus.replace('ID', id), 'DELETE'); setCart(r.data); } catch (e) { showToast(e.message, 'error'); } }
    async function updateQty(id, d) { const item = cart.find(i => i.id == id); if (!item) return; if (item.qty + d <= 0) { removeFromCart(id); return; } try { const r = await api(APP.routes.keranjangUpdate.replace('ID', id), 'PUT', { qty: item.qty + d }); setCart(r.data); } catch (e) { showToast(e.message, 'error'); } }

    function getSub() { 
        return cart
            .filter(i => selectedCartIds.includes(i.id) || selectedCartIds.includes(String(i.id)) || selectedCartIds.includes(Number(i.id)))
            .reduce((s, i) => s + i.harga * i.qty, 0); 
    }
    function formatRp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

    function updateCartUI() {
        const badge = document.getElementById('cart-badge'), footer = document.getElementById('cart-footer'), total = cart.reduce((s, i) => s + i.qty, 0);
        if (total > 0) { 
            badge.classList.remove('hidden'); 
            badge.classList.add('flex'); 
            badge.textContent = total; 
            footer.classList.remove('hidden'); 
            document.getElementById('cart-select-all-container')?.classList.remove('hidden');
        } else { 
            badge.classList.add('hidden'); 
            badge.classList.remove('flex'); 
            footer.classList.add('hidden'); 
            document.getElementById('cart-select-all-container')?.classList.add('hidden');
        }
        
        const selectAllCheckbox = document.getElementById('cart-select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = cart.length > 0 && selectedCartIds.length === cart.length;
        }

        document.getElementById('cart-subtotal').textContent = formatRp(getSub());
        const empty = `<div id="cart-empty" class="${cart.length > 0 ? 'hidden' : ''} flex flex-col items-center justify-center h-full text-center"><i class="fa-solid fa-bag-shopping text-5xl text-slate-700 mb-4"></i><p class="text-slate-500">Keranjang masih kosong</p></div>`;
        const items = cart.map(i => {
            const isChecked = selectedCartIds.includes(i.id) || selectedCartIds.includes(String(i.id)) || selectedCartIds.includes(Number(i.id));
            return `<div class="flex items-center gap-3 bg-slate-800/50 rounded-xl p-3 border border-slate-700/20">
                <input type="checkbox" class="rounded border-slate-700 text-brand-500 focus:ring-brand-500/20 bg-slate-800 w-4 h-4 transition-colors" ${isChecked ? 'checked' : ''} onchange="toggleSelectCartItem('${i.id}')">
                <img src="${i.foto || '/images/default-product.png'}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-500">Size: ${i.ukuran ?? '-'} | Warna: ${i.warna ?? '-'}</p>
                        </div>
                        <button onclick="removeFromCart('${i.id}')" class="text-slate-600 hover:text-rose-400 ml-2"><i class="fa-solid fa-trash-can text-xs"></i></button>
                    </div>
                    <p class="text-sm font-bold text-brand-400 mt-1">${formatRp(i.harga * i.qty)}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <button onclick="updateQty('${i.id}',-1)" class="w-6 h-6 bg-slate-700 hover:bg-slate-600 rounded-md flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-minus"></i></button>
                        <span class="text-sm font-medium text-white w-6 text-center">${i.qty}</span>
                        <button onclick="updateQty('${i.id}',1)" class="w-6 h-6 bg-slate-700 hover:bg-slate-600 rounded-md flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>`;
        }).join('');
        document.getElementById('cart-items').innerHTML = empty + items;
    }

    function openCart() { document.getElementById('cart-overlay').classList.remove('hidden'); setTimeout(() => { document.getElementById('cart-overlay').classList.remove('opacity-0'); document.getElementById('cart-sidebar').classList.remove('translate-x-full'); }, 10); document.body.style.overflow = 'hidden'; }
    function closeCart() { document.getElementById('cart-overlay').classList.add('opacity-0'); document.getElementById('cart-sidebar').classList.add('translate-x-full'); setTimeout(() => document.getElementById('cart-overlay').classList.add('hidden'), 300); document.body.style.overflow = ''; }

    function openAccount(tab = 'dashboard') { 
        const overlay = document.getElementById('account-overlay');
        const sidebar = document.getElementById('account-sidebar');
        if (!overlay || !sidebar) return;
        overlay.classList.remove('hidden'); 
        setTimeout(() => { 
            overlay.classList.remove('opacity-0'); 
            sidebar.classList.remove('translate-x-full'); 
        }, 10); 
        document.body.style.overflow = 'hidden'; 
        switchAccountTab(tab); 
        const dd = document.getElementById('dd-menu');
        if (dd) dd.classList.add('hidden');
    }
    
    function closeAccount() { 
        const overlay = document.getElementById('account-overlay');
        const sidebar = document.getElementById('account-sidebar');
        if (!overlay || !sidebar) return;
        overlay.classList.add('opacity-0'); 
        sidebar.classList.add('translate-x-full'); 
        setTimeout(() => overlay.classList.add('hidden'), 300); 
        document.body.style.overflow = ''; 
    }
    
    function switchAccountTab(tab) {
        const tabs = ['dashboard', 'pesanan', 'profil', 'alamat', 'ulasan', 'wishlist'];
        tabs.forEach(t => {
            const btn = document.getElementById('btn-acc-' + t);
            const content = document.getElementById('tab-acc-content-' + t);
            if (btn && content) {
                if (t === tab) {
                    btn.className = 'flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-brand-500 text-brand-400 transition-all';
                    content.classList.remove('hidden');
                } else {
                    btn.className = 'flex-1 min-w-[120px] py-3.5 text-sm font-semibold text-center border-b-2 border-transparent text-slate-400 hover:text-white transition-all';
                    content.classList.add('hidden');
                }
            }
        });
        
        if (tab === 'wishlist') {
            loadWishlist();
        }
    }

    function openWishlist() {
        <?php if(auth()->guard()->check()): ?>
            openAccount('wishlist');
        <?php else: ?>
            openAuthModal('login');
        <?php endif; ?>
    }

    function loadWishlist() {
        const container = document.getElementById('wishlist-items-container');
        const loading = document.getElementById('wishlist-loading');
        const empty = document.getElementById('wishlist-empty');

        if (!container || !loading || !empty) return;

        loading.classList.remove('hidden');
        container.classList.add('hidden');
        empty.classList.add('hidden');

        fetch('/api/wishlist')
            .then(res => res.json())
            .then(res => {
                loading.classList.add('hidden');
                if (res.status === 'success') {
                    updateWishlistBadge(res.data.length);

                    if (res.data.length === 0) {
                        empty.classList.remove('hidden');
                    } else {
                        container.classList.remove('hidden');
                        container.innerHTML = res.data.map(item => `
                            <div class="flex items-center gap-4 bg-slate-800/30 border border-slate-700/20 rounded-2xl p-4 transition-all duration-300 hover:border-slate-700/50">
                                <img src="${item.thumbnail_url}" class="w-16 h-16 rounded-xl object-cover" alt="${item.name}">
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] font-semibold text-brand-400 uppercase tracking-wide">${item.brand_name}</span>
                                    <h4 class="text-sm font-bold text-white truncate mt-0.5">${item.name}</h4>
                                    <p class="text-xs text-brand-400 font-bold mt-1">${item.formatted_price}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="buyWishlistItem('${item.product_id}')" class="w-8 h-8 rounded-lg bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white flex items-center justify-center transition-all duration-200" title="Beli Sekarang">
                                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                                    </button>
                                    <button onclick="toggleWishlist('${item.product_id}', true)" class="w-8 h-8 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white flex items-center justify-center transition-all duration-200" title="Hapus dari Favorit">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        `).join('');
                    }
                }
            })
            .catch(err => {
                loading.classList.add('hidden');
                showToast('Gagal memuat wishlist.', 'error');
            });
    }

    function toggleWishlist(productId, fromSidebar = false) {
        <?php if(auth()->guard()->guest()): ?>
            openAuthModal('login');
            return;
        <?php endif; ?>

        fetch('/api/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                updateWishlistBadge(res.count);

                const btns = document.querySelectorAll('#wishlist-btn-' + productId);
                btns.forEach(btn => {
                    const icon = btn.querySelector('i');
                    if (res.wishlist_status === 'added') {
                        icon.className = 'fa-solid fa-heart text-rose-500';
                    } else {
                        icon.className = 'fa-regular fa-heart';
                    }
                });

                if (res.wishlist_status === 'added') {
                    showToast('Produk berhasil disimpan ke favorit!');
                } else {
                    showToast('Produk dihapus dari favorit.');
                }

                const currentTabActive = document.getElementById('btn-acc-wishlist')?.classList.contains('text-brand-400');
                if (fromSidebar || currentTabActive) {
                    loadWishlist();
                }
            } else {
                showToast('Gagal mengubah wishlist.', 'error');
            }
        })
        .catch(err => {
            showToast('Terjadi kesalahan koneksi.', 'error');
        });
    }

    async function buyWishlistItem(productId) {
        try {
            closeAccount();
            // Tambahkan ke keranjang via API
            const r = await api(APP.routes.keranjangTambah, 'POST', { produk_id: productId, qty: 1 });
            setCart(r.data);

            // Temukan item yang baru ditambahkan di dalam keranjang
            const addedItem = r.data.find(i => i.produk_id == productId);
            if (addedItem) {
                // Pilih HANYA item ini saja untuk langsung di-checkout
                selectedCartIds = [addedItem.id];
            }

            // Buka modal checkout secara instan
            openCheckout();
        } catch (e) {
            showToast(e.message || 'Gagal memulai checkout', 'error');
            if (e.message && e.message.toLowerCase().includes('login')) {
                setTimeout(() => openAuthModal('login'), 800);
            }
        }
    }

    function updateWishlistBadge(count) {
        const badge = document.getElementById('wishlist-badge');
        if (badge) {
            badge.innerText = count;
            if (count > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    async function submitProfile(e) {
        e.preventDefault();
        const fd = new FormData(e.target), data = Object.fromEntries(fd.entries());
        const btn = document.getElementById('submit-profile-btn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Menyimpan...';
        try {
            const r = await api('<?php echo e(route("api.pembeli.profil")); ?>', 'POST', data);
            showToast(r.message || 'Profil berhasil diperbarui.', 'success');
            if (r.user) {
                const navName = document.getElementById('nav-user-name');
                const ddName = document.getElementById('dd-user-name');
                if (navName) navName.textContent = r.user.name;
                if (ddName) ddName.textContent = r.user.name;
            }
        } catch (e) { 
            showToast(e.message || 'Gagal menyimpan profil', 'error'); 
        } finally { 
            btn.disabled = false; 
            btn.innerHTML = '<i class="fa-solid fa-save mr-2 text-xs"></i>Simpan Perubahan'; 
        }
    }

    function handleCheckoutClick() {
        if (!cart.length) return;
        const selectedCount = cart.filter(i => selectedCartIds.includes(i.id) || selectedCartIds.includes(String(i.id)) || selectedCartIds.includes(Number(i.id))).length;
        if (selectedCount === 0) {
            showToast('Pilih minimal satu produk untuk checkout', 'error');
            return;
        }
        if (!APP.isLoggedIn) { closeCart(); setTimeout(() => openAuthModal('login'), 350); return; }
        openCheckout();
    }

window.adjustModalQty = function(d) {
    const input = document.getElementById('modal-qty');
    if (!input) return;
    let val = parseInt(input.value) || 1;
    val += d;
    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 99;
    if (val < min) val = min;
    if (val > max) val = max;
    input.value = val;
}

async function openProductModal(id) {
    const modal = document.getElementById('product-modal'), content = document.getElementById('product-modal-content');
    modal.classList.remove('hidden'); document.body.style.overflow = 'hidden';
    content.innerHTML = '<div class="flex items-center justify-center h-64"><i class="fa-solid fa-spinner fa-spin text-brand-400 text-2xl"></i></div>';
    try {
        const r = await api(APP.routes.produkDetail.replace('ID', id)), p = r.data;
        
        // PERBAIKAN: Langsung pakai thumbnail_url (sudah dihandle oleh Model)
        const fotoUrl = p.thumbnail_url || (p.images && p.images.length > 0 ? p.images[0].url : '/images/default-product.png');
                // TAMBAHKAN INI UNTUK DEBUG
        console.log('DATA PRODUK:', p);
        console.log('URL GAMBAR YANG DIPAKAI:', fotoUrl);
        
        content.innerHTML = `<div class="relative"><img src="${fotoUrl}" class="w-full h-64 sm:h-80 object-cover rounded-t-2xl"><button onclick="closeProductModal()" class="absolute top-4 right-4 w-10 h-10 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-xmark"></i></button><span class="absolute top-4 left-4 px-3 py-1.5 ${(p.stok??p.stock??0)<=5?'bg-rose-500':'bg-brand-500'} text-white text-xs font-bold rounded-lg">Stok: ${p.stok??p.stock??0}</span></div><div class="p-6 sm:p-8"><p class="text-xs text-brand-400 font-semibold uppercase tracking-wider mb-2">${p.brand?.nama ?? p.brand?.name ?? 'UMKM'}</p><h2 class="text-2xl font-bold text-white mb-3">${p.nama ?? p.name}</h2><div class="flex items-center gap-4 mb-4"><div class="flex items-center gap-1">${Array(5).fill(0).map((_,i)=>'<i class="fa-solid fa-star text-xs '+(i<Math.floor(p.rating||0)?'text-amber-400':'text-slate-700')+'"></i>').join('')}<span class="text-sm text-slate-400 ml-1">${Number(p.rating||0).toFixed(1)}</span></div><span class="text-slate-700">|</span><span class="text-sm text-slate-500">Terjual ${p.terjual??0}</span></div><p class="text-2xl font-bold text-brand-400 mb-4">${formatRp(p.harga ?? p.price ?? 0)}</p><p class="text-sm text-slate-400 leading-relaxed mb-6">${p.deskripsi ?? p.description ?? ''}</p><div class="mb-6 space-y-4"><div><p class="text-sm font-medium text-white mb-2">Pilih Ukuran:</p><div class="flex flex-wrap gap-2" id="size-opt">${(p.sizes??[]).length>0?(p.sizes??[]).map((s,i)=>'<button type="button" onclick="pickSize(this,\''+s+'\')" class="sz px-4 py-2 border border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-lg text-sm font-medium transition-all">'+s+'</button>').join(''):'<span class="text-xs text-slate-500">Tidak ada pilihan ukuran</span>'}</div><input type="hidden" id="sel-size" value=""></div><div><p class="text-sm font-medium text-white mb-2">Pilih Warna:</p><div class="flex flex-wrap gap-2" id="color-opt">${(p.colors??[]).length>0?(p.colors??[]).map((c,i)=>'<button type="button" onclick="pickColor(this,\''+c+'\')" class="cl px-4 py-2 border border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-lg text-sm font-medium transition-all">'+c+'</button>').join(''):'<span class="text-xs text-slate-500">Tidak ada pilihan warna</span>'}</div><input type="hidden" id="sel-color" value=""></div><div><p class="text-sm font-medium text-white mb-2">Jumlah:</p><div class="flex items-center gap-2"><button type="button" onclick="adjustModalQty(-1)" class="w-8 h-8 bg-slate-800 border border-slate-700/50 hover:bg-slate-700 text-slate-300 rounded-lg flex items-center justify-center transition-all"><i class="fa-solid fa-minus text-xs"></i></button><input type="number" id="modal-qty" value="1" min="1" max="${p.stok??p.stock??99}" class="w-12 h-8 bg-slate-800 border border-slate-700/50 text-white text-center text-sm rounded-lg focus:outline-none focus:border-brand-500" readonly><button type="button" onclick="adjustModalQty(1)" class="w-8 h-8 bg-slate-800 border border-slate-700/50 hover:bg-slate-700 text-slate-300 rounded-lg flex items-center justify-center transition-all"><i class="fa-solid fa-plus text-xs"></i></button></div></div></div><button onclick="addToCartModal('${p.id}')" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 transition-all flex items-center justify-center gap-2"><i class="fa-solid fa-bag-shopping text-sm"></i> Tambah ke Keranjang</button></div>`;
    } catch (e) { content.innerHTML = `<div class="p-10 text-center"><i class="fa-solid fa-circle-exclamation text-rose-400 text-3xl mb-4"></i><p class="text-slate-400">${e.message||'Gagal memuat'}</p><button onclick="closeProductModal()" class="mt-4 text-brand-400 text-sm font-medium">Tutup</button></div>`; }
}
    function closeProductModal() { document.getElementById('product-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function pickSize(btn, s) { document.getElementById('sel-size').value = s; document.querySelectorAll('#size-opt .sz').forEach(b => { b.className = 'sz px-4 py-2 border border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-lg text-sm font-medium transition-all'; }); btn.className = 'sz px-4 py-2 border border-brand-500 bg-brand-500/10 text-brand-400 rounded-lg text-sm font-medium transition-all'; }
    function pickColor(btn, c) { document.getElementById('sel-color').value = c; document.querySelectorAll('#color-opt .cl').forEach(b => { b.className = 'cl px-4 py-2 border border-slate-600 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-lg text-sm font-medium transition-all'; }); btn.className = 'cl px-4 py-2 border border-brand-500 bg-brand-500/10 text-brand-400 rounded-lg text-sm font-medium transition-all'; }
    
    function addToCartModal(id) {
        const hasSizes = document.querySelectorAll('#size-opt .sz').length > 0;
        const hasColors = document.querySelectorAll('#color-opt .cl').length > 0;
        const selectedSize = document.getElementById('sel-size').value;
        const selectedColor = document.getElementById('sel-color').value;
        
        if (hasSizes && !selectedSize) {
            showToast('Silakan pilih ukuran terlebih dahulu!', 'error');
            return;
        }
        if (hasColors && !selectedColor) {
            showToast('Silakan pilih warna terlebih dahulu!', 'error');
            return;
        }
        
        const qty = parseInt(document.getElementById('modal-qty').value) || 1;
        quickAddToCart(id, selectedSize, selectedColor, qty);
        closeProductModal();
    }

    function openCheckout() { 
        if (!cart.length) return; 
        const selectedCount = cart.filter(i => selectedCartIds.includes(i.id) || selectedCartIds.includes(String(i.id)) || selectedCartIds.includes(Number(i.id))).length;
        if (selectedCount === 0) return;
        closeCart(); 
        setTimeout(() => { 
            document.getElementById('checkout-modal').classList.remove('hidden'); 
            document.body.style.overflow = 'hidden'; 
            renderCheckoutSummary(); 
            updateShipping(); 
        }, 350); 
    }
    function closeCheckout() { document.getElementById('checkout-modal').classList.add('hidden'); document.body.style.overflow = ''; }
    function renderCheckoutSummary() {
        const selectedItems = cart.filter(i => selectedCartIds.includes(i.id) || selectedCartIds.includes(String(i.id)) || selectedCartIds.includes(Number(i.id)));
        document.getElementById('checkout-summary').innerHTML = selectedItems.map(i => `<div class="flex justify-between"><span class="text-slate-400 truncate mr-4">${i.nama} <span class="text-slate-600">(x${i.qty}, size ${i.ukuran ?? '-'}, warna ${i.warna ?? '-'})</span></span><span class="text-white font-medium flex-shrink-0">${formatRp(i.harga * i.qty)}</span></div>`).join('');
        document.getElementById('checkout-subtotal').textContent = formatRp(getSub());
    }
    const citiesByProvince = {
        'aceh': ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang', 'Subulussalam', 'Aceh Besar', 'Aceh Jaya'],
        'sumatera-utara': ['Medan', 'Binjai', 'Gunungsitoli', 'Padang Sidempuan', 'Pematangsiantar', 'Sibolga', 'Tanjungbalai', 'Tebing Tinggi', 'Deli Serdang'],
        'sumatera-barat': ['Padang', 'Bukittinggi', 'Payakumbuh', 'Pariaman', 'Solok', 'Sawahlunto', 'Padang Panjang', 'Pesisir Selatan'],
        'riau': ['Pekanbaru', 'Dumai', 'Kampar', 'Siak', 'Pelalawan', 'Bengkalis'],
        'kepulauan-riau': ['Tanjungpinang', 'Batam', 'Bintan', 'Karimun', 'Anambas', 'Natuna', 'Lingga'],
        'jambi': ['Jambi', 'Sungaipenuh', 'Muaro Jambi', 'Bungo', 'Tebo', 'Kerinci'],
        'bengkulu': ['Bengkulu', 'Rejang Lebong', 'Muko Muko', 'Kepahiang'],
        'sumatera-selatan': ['Palembang', 'Lubuklinggau', 'Pagar Alam', 'Prabumulih', 'Ogan Ilir', 'Banyuasin'],
        'bangka-belitung': ['Pangkalpinang', 'Bangka', 'Belitung', 'Bangka Barat', 'Bangka Tengah'],
        'lampung': ['Bandar Lampung', 'Metro', 'Lampung Selatan', 'Lampung Tengah', 'Pringsewu'],
        'dki-jakarta': ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Barat', 'Jakarta Utara', 'Kepulauan Seribu'],
        'banten': ['Tangerang', 'Serang', 'Cilegon', 'Tangerang Selatan', 'Lebak', 'Pandeglang'],
        'jawa-barat': ['Bandung', 'Bekasi', 'Depok', 'Bogor', 'Tasikmalaya', 'Cirebon', 'Cimahi', 'Sukabumi', 'Banjar', 'Karawang', 'Sumedang'],
        'jawa-tengah': ['Semarang', 'Surakarta (Solo)', 'Magelang', 'Pekalongan', 'Tegal', 'Salatiga', 'Banyumas', 'Kudus', 'Klaten'],
        'diy-yogyakarta': ['Yogyakarta', 'Sleman', 'Bantul', 'Kulon Progo', 'Gunungkidul'],
        'jawa-timur': ['Surabaya', 'Malang', 'Madiun', 'Kediri', 'Probolinggo', 'Pasuruan', 'Batu', 'Blitar', 'Mojokerto', 'Sidoarjo', 'Gresik', 'Jember'],
        'bali': ['Denpasar', 'Badung', 'Gianyar', 'Buleleng', 'Tabanan', 'Klungkung', 'Karangasem'],
        'ntb': ['Mataram', 'Bima', 'Lombok Barat', 'Lombok Timur', 'Lombok Tengah', 'Sumbawa'],
        'ntt': ['Kupang', 'Ende', 'Sikka', 'Flores Timur', 'Alor', 'Manggarai'],
        'kalimantan-barat': ['Pontianak', 'Singkawang', 'Kubu Raya', 'Mempawah', 'Ketapang'],
        'kalimantan-tengah': ['Palangkaraya', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Kapuas'],
        'kalimantan-selatan': ['Banjarmasin', 'Banjarbaru', 'Banjar', 'Tanah Laut', 'Tabalong'],
        'kalimantan-timur': ['Samarinda', 'Balikpapan', 'Bontang', 'Kutai Kartanegara', 'Kutai Timur'],
        'kalimantan-utara': ['Tarakan', 'Bulungan', 'Malinau', 'Nunukan'],
        'sulawesi-utara': ['Manado', 'Bitung', 'Kotamobagu', 'Tomohon', 'Minahasa', 'Sangihe'],
        'gorontalo': ['Gorontalo', 'Boalemo', 'Bone Bolango'],
        'sulawesi-tengah': ['Palu', 'Donggala', 'Poso', 'Toli-Toli', 'Banggai'],
        'sulawesi-barat': ['Mamuju', 'Majene', 'Polewali Mandar'],
        'sulawesi-selatan': ['Makassar', 'Palopo', 'Parepare', 'Gowa', 'Maros', 'Bone', 'Toraja'],
        'sulawesi-tenggara': ['Kendari', 'Bau-Bau', 'Kolaka', 'Muna', 'Buton'],
        'maluku': ['Ambon', 'Tual', 'Maluku Tengah', 'Maluku Tenggara'],
        'maluku-utara': ['Ternate', 'Tidore Kepulauan', 'Halmahera Utara', 'Halmahera Barat'],
        'papua-barat': ['Manokwari', 'Fakfak', 'Kaimana', 'Teluk Wondama'],
        'papua': ['Jayapura', 'Keerom', 'Sarmi', 'Biak Numfor'],
        'papua-tengah': ['Nabire', 'Mimika', 'Paniai', 'Puncak Jaya'],
        'papua-pegunungan': ['Wamena', 'Jayawijaya', 'Lanny Jaya', 'Tolikara'],
        'papua-selatan': ['Merauke', 'Boven Digoel', 'Asmat', 'Mappi'],
        'papua-barat-daya': ['Sorong', 'Raja Ampat', 'Tambrauw', 'Maybrat']
    };

    function handleProvinceChange() {
        const p = document.getElementById('provinsi-select').value;
        const citySelect = document.getElementById('kota-select');
        
        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
        
        if (p && citiesByProvince[p]) {
            citiesByProvince[p].forEach(city => {
                const opt = document.createElement('option');
                opt.value = city.toLowerCase().replace(/\s+/g, '-');
                opt.textContent = city;
                citySelect.appendChild(opt);
            });
        }
        
        updateShipping();
    }

    function updateShipping() {
        const p = document.getElementById('provinsi-select').value, k = document.getElementById('kurir-select').value;
        const rate = (p && k && shippingRates[p]?.[k]) ? shippingRates[p][k] : null;
        
        shippingCost = rate ? (typeof rate === 'object' ? (rate.cost || 0) : rate) : 0;
        const est = rate && typeof rate === 'object' ? rate.estimation : null;
        
        const s = document.getElementById('checkout-shipping'), g = document.getElementById('checkout-grand-total');
        const estEl = document.getElementById('checkout-estimation');
        
        if (shippingCost > 0) {
            s.textContent = formatRp(shippingCost);
            g.textContent = formatRp(getSub() + shippingCost);
            if (estEl) {
                estEl.textContent = est ? `Estimasi: ${est}` : 'Estimasi: 2-4 Hari';
                estEl.classList.remove('hidden');
            }
        } else {
            s.textContent = 'Pilih lokasi & kurir';
            g.textContent = '-';
            if (estEl) {
                estEl.textContent = '';
                estEl.classList.add('hidden');
            }
        }
    }

    async function submitOrder(e) {
        e.preventDefault();
        const fd = new FormData(e.target), data = Object.fromEntries(fd.entries());
        if (!data.alamat || data.alamat.length < 10) { showToast('Alamat minimal 10 karakter', 'error'); return; }
        if (!data.provinsi || !data.kota || !data.kurir || !data.pembayaran) { showToast('Lengkapi semua field', 'error'); return; }
        if (shippingCost === 0) { showToast('Pilih provinsi dan kurir', 'error'); return; }
        const btn = document.getElementById('submit-order-btn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Memproses...';
        try {
            data.ongkir = shippingCost; 
            data.total = getSub() + shippingCost;
            selectedCartIds.forEach(id => {
                data[`cart_item_ids[]`] = data[`cart_item_ids[]`] || [];
                data[`cart_item_ids[]`].push(id);
            });
            const params = new URLSearchParams(new FormData(e.target));
            selectedCartIds.forEach(id => {
                params.append('cart_item_ids[]', id);
            });
            params.append('ongkir', shippingCost);
            params.append('total', getSub() + shippingCost);
            
            const payload = {
                alamat: data.alamat,
                provinsi: data.provinsi,
                kota: data.kota,
                kurir: data.kurir,
                pembayaran: data.pembayaran,
                catatan: data.catatan,
                ongkir: shippingCost,
                total: getSub() + shippingCost,
                cart_item_ids: selectedCartIds
            };
            
            const r = await api(APP.routes.checkout, 'POST', payload);
            await loadCart();
            shippingCost = 0; 
            closeCheckout(); 
            e.target.reset();
            document.getElementById('invoice-number').textContent = r.data?.code ?? '-';
            document.getElementById('success-modal').classList.remove('hidden');
        } catch (e) { showToast(e.errors ? Object.values(e.errors)[0][0] : (e.message || 'Gagal'), 'error'); }
        finally { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i>Buat Pesanan'; }
    }
    function closeSuccessModal() { document.getElementById('success-modal').classList.add('hidden'); document.body.style.overflow = ''; }

    function setCategory(cat) { currentCategory = cat; document.querySelectorAll('.cat-btn').forEach(b => { b.className = b.dataset.cat === cat ? 'cat-btn active-cat flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-brand-500 text-white' : 'cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-slate-800 text-slate-400 border border-slate-700/30 hover:border-brand-500/50 hover:text-white'; }); filterProducts(); }
    function filterProducts() { 
        const q = (document.getElementById('search-input')?.value || '').toLowerCase().trim(); 
        let n = 0; 
        document.querySelectorAll('.product-card').forEach(c => { 
            const name = (c.dataset.name || '').toLowerCase();
            const kategori = (c.dataset.kategori || '').toLowerCase();
            const umkm = (c.dataset.umkm || '').toLowerCase();
            const ok = (currentCategory === 'semua' || c.dataset.kategori === currentCategory) && 
                       (!q || name.includes(q) || kategori.includes(q) || umkm.includes(q)); 
            c.style.display = ok ? '' : 'none'; 
            if (ok) n++; 
        }); 
        document.getElementById('empty-state').classList.toggle('hidden', n > 0); 
    }

    let currentPage = 1;
    let hasMoreProducts = true;

    async function loadMoreProducts() {
        if (!hasMoreProducts) return;

        const btn = document.getElementById('btn-load-more');
        const spinner = document.getElementById('spinner-load-more');
        
        btn.disabled = true;
        spinner.classList.remove('hidden');

        currentPage++;

        try {
            const response = await fetch(`/api/produk-more?page=${currentPage}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                
                if (data.html && data.html.trim() !== '') {
                    const grid = document.getElementById('product-grid');
                    grid.insertAdjacentHTML('beforeend', data.html);
                    
                    // Re-run filter in case a category search is active
                    filterProducts();
                    
                    // Observe new elements for fade-up effect
                    document.querySelectorAll('.fade-up:not(.visible)').forEach(el => obs.observe(el));
                }

                if (!data.hasMore) {
                    hasMoreProducts = false;
                    const container = document.getElementById('load-more-container');
                    if (container) container.classList.add('hidden');
                }
            } else {
                showToast('Gagal memuat produk tambahan', 'error');
                currentPage--;
            }
        } catch (err) {
            console.error(err);
            showToast('Terjadi kesalahan koneksi', 'error');
            currentPage--;
        } finally {
            btn.disabled = false;
            spinner.classList.add('hidden');
        }
    }

    function toggleSearch() { const b = document.getElementById('search-bar'); b.classList.toggle('hidden'); if (!b.classList.contains('hidden')) document.getElementById('search-input').focus(); }
    function toggleMobileMenu() { const m = document.getElementById('mobile-menu'); m.classList.toggle('hidden'); document.getElementById('mob-icon').className = m.classList.contains('hidden') ? 'fa-solid fa-bars' : 'fa-solid fa-xmark'; }
    function showToast(msg, type = 'success') { const c = document.getElementById('toast-container'), t = document.createElement('div'); t.className = `toast-enter flex items-center gap-3 px-5 py-4 bg-slate-800 border ${type==='success'?'border-brand-500/30':'border-rose-500/30'} rounded-xl shadow-2xl max-w-sm`; t.innerHTML = `<i class="fa-solid ${type==='success'?'fa-circle-check text-brand-400':'fa-circle-exclamation text-rose-400'} text-lg flex-shrink-0"></i><p class="text-sm text-slate-200">${msg}</p>`; c.appendChild(t); setTimeout(() => { t.classList.remove('toast-enter'); t.classList.add('toast-exit'); setTimeout(() => t.remove(), 300); }, 3000); }

    const obs = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) x.target.classList.add('visible'); }), { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
    window.addEventListener('scroll', () => { const n = document.getElementById('navbar'); n.classList.toggle('shadow-xl', scrollY > 100); n.classList.toggle('shadow-black/20', scrollY > 100); });
    document.querySelectorAll('[id="flash-msg"]').forEach(el => setTimeout(() => { el.classList.add('toast-exit'); setTimeout(() => el.remove(), 300); }, 5000));
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();

        // Parse user orders
        try {
            const el = document.getElementById('user-orders-data');
            if (el) {
                userOrders = JSON.parse(el.textContent);
            }
        } catch(e) {
            console.error("Gagal parse orders data", e);
        }

        const urlParams = new URLSearchParams(window.location.search);
        const openAcc = urlParams.get('open_account');
        if (openAcc) {
            // Give it a tiny delay to ensure everything is rendered
            setTimeout(() => openAccount(openAcc), 100);
        }
        const openOrder = urlParams.get('open_order');
        if (openOrder) {
            setTimeout(() => {
                openOrderDetail(openOrder);
            }, 300);
        }
    });

    // Order Detail Modal helper
    let userOrders = [];

    function openOrderDetail(invoice) {
        const order = userOrders.find(o => o.invoice === invoice);
        if (!order) {
            showToast('Pesanan tidak ditemukan', 'error');
            return;
        }

        document.getElementById('od-invoice').textContent = order.invoice;
        
        // Format Date
        const dateObj = new Date(order.created_at);
        const options = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('od-date').textContent = dateObj.toLocaleDateString('id-ID', options);

        // Status Badge
        const statusEl = document.getElementById('od-status-badge');
        let statusBadge = '';
        const statusLower = (order.status || '').toLowerCase();
        if (statusLower === 'menunggu') {
            statusBadge = `<span class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-clock mr-1"></i>Menunggu</span>`;
        } else if (statusLower === 'dikonfirmasi') {
            statusBadge = `<span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-circle-check mr-1"></i>Dikonfirmasi</span>`;
        } else if (statusLower === 'dikemas') {
            statusBadge = `<span class="px-3 py-1 bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-box mr-1"></i>Dikemas</span>`;
        } else if (statusLower === 'dikirim') {
            statusBadge = `<span class="px-3 py-1 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-truck mr-1"></i>Dikirim</span>`;
        } else if (statusLower === 'diperjalanan') {
            statusBadge = `<span class="px-3 py-1 bg-orange-500/10 border border-orange-500/20 text-orange-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-truck-fast mr-1"></i>Perjalanan</span>`;
        } else if (statusLower === 'selesai') {
            statusBadge = `<span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-circle-check mr-1"></i>Selesai</span>`;
        } else if (statusLower === 'dibatalkan') {
            statusBadge = `<span class="px-3 py-1 bg-rose-500/10 border border-rose-500/20 text-rose-400 text-[10px] font-bold rounded-lg uppercase tracking-wide"><i class="fa-solid fa-circle-xmark mr-1"></i>Batal</span>`;
        } else {
            statusBadge = `<span class="px-3 py-1 bg-slate-700 text-slate-300 text-[10px] font-bold rounded-lg uppercase tracking-wide">${order.status}</span>`;
        }
        statusEl.innerHTML = statusBadge;

        // Recipient details
        document.getElementById('od-recipient-name').textContent = order.shipping_name || '-';
        document.getElementById('od-recipient-phone').textContent = order.shipping_phone || '-';
        document.getElementById('od-recipient-address').textContent = order.shipping_address || '-';

        // Payment details
        document.getElementById('od-payment-method').textContent = order.payment_method || '-';
        
        const payStatusEl = document.getElementById('od-payment-status');
        const payStatusLower = (order.payment_status || '').toLowerCase();
        if (payStatusLower === 'paid' || payStatusLower === 'lunas') {
            payStatusEl.className = 'font-bold text-emerald-400';
            payStatusEl.textContent = 'Lunas';
        } else if (payStatusLower === 'menunggu_verifikasi') {
            payStatusEl.className = 'font-bold text-blue-400';
            payStatusEl.textContent = 'Menunggu Verifikasi';
        } else {
            payStatusEl.className = 'font-bold text-amber-400';
            payStatusEl.textContent = 'Belum Bayar';
        }

        // Total
        document.getElementById('od-total-pay').textContent = 'Rp ' + Number(order.total || 0).toLocaleString('id-ID');

        // Show/hide payment instructions for Transfer Manual & E-Wallet
        const instructionsEl = document.getElementById('od-payment-instructions');
        const transferBox = document.getElementById('od-transfer-instructions-box');
        const ewalletBox = document.getElementById('od-ewallet-instructions-box');
        const titleEl = document.getElementById('od-payment-instructions-title');

        if (order.payment_method === 'transfer' || order.payment_method === 'ewallet') {
            instructionsEl.classList.remove('hidden');
            
            if (order.payment_method === 'transfer') {
                if (titleEl) titleEl.textContent = 'Petunjuk Pembayaran Transfer Bank';
                if (transferBox) transferBox.classList.remove('hidden');
                if (ewalletBox) ewalletBox.classList.add('hidden');
                
                // Set transfer amount
                document.getElementById('od-transfer-amount').textContent = 'Rp ' + Number(order.total || 0).toLocaleString('id-ID');
                
                // Render dynamic bank accounts
                const transferCfg = APP.paymentMethods.transfer;
                const bankAccountsList = document.getElementById('od-bank-accounts-list');
                if (transferCfg && transferCfg.details && bankAccountsList) {
                    bankAccountsList.innerHTML = transferCfg.details.map(acc => `
                        <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                            <p class="font-bold text-slate-300 text-brand-400">Bank ${acc.bank}</p>
                            <p class="text-white font-mono mt-1 text-sm">${acc.account_number}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">a.n. ${acc.account_name}</p>
                        </div>
                    `).join('');
                }
                
                // Set unique code
                const uniqueCodeEl = document.getElementById('od-transfer-unique-code');
                const uniqueCodeContainer = document.getElementById('od-unique-code-container');
                if (order.unique_code) {
                    if (uniqueCodeEl) uniqueCodeEl.textContent = order.unique_code;
                    if (uniqueCodeContainer) uniqueCodeContainer.classList.remove('hidden');
                } else {
                    if (uniqueCodeContainer) uniqueCodeContainer.classList.add('hidden');
                }
            } else {
                if (titleEl) titleEl.textContent = 'Petunjuk Pembayaran E-Wallet (QRIS)';
                if (transferBox) transferBox.classList.add('hidden');
                if (ewalletBox) ewalletBox.classList.remove('hidden');
                
                // Set ewallet amount
                document.getElementById('od-ewallet-amount').textContent = 'Rp ' + Number(order.total || 0).toLocaleString('id-ID');
                
                // Render dynamic QRIS/E-Wallet details
                const ewalletCfg = APP.paymentMethods.ewallet;
                if (ewalletCfg && ewalletCfg.details) {
                    const qrisImg = document.getElementById('od-qris-image');
                    const qrisPhone = document.getElementById('od-qris-phone');
                    const qrisHolder = document.getElementById('od-qris-holder');
                    
                    if (qrisImg) qrisImg.src = ewalletCfg.details.qris_image || '/images/qris_mockup.png';
                    if (qrisPhone) qrisPhone.textContent = ewalletCfg.details.phone || '-';
                    if (qrisHolder) qrisHolder.textContent = 'a.n. ' + (ewalletCfg.details.account_name || '-');
                }
            }

            // Set upload form data
            const formEl = document.getElementById('od-upload-proof-form');
            formEl.dataset.orderId = order.id;

           if (statusLower === 'menunggu') {
                formEl.classList.remove('hidden');
            } else {
                formEl.classList.add('hidden');
            }

            // Show/hide uploaded proof preview
            const proofUploadedContainer = document.getElementById('od-proof-uploaded-container');
            const proofUploadedImg = document.getElementById('od-proof-uploaded-img');
            
            if (order.payment_proof) {
                proofUploadedContainer.classList.remove('hidden');
                proofUploadedImg.src = `/storage/${order.payment_proof}`;
            } else {
                proofUploadedContainer.classList.add('hidden');
                proofUploadedImg.src = '';
            }
        } else {
            instructionsEl.classList.add('hidden');
        }

        // Products List
        const listEl = document.getElementById('od-products-list');
        listEl.innerHTML = '';
        if (order.items && order.items.length) {
            order.items.forEach(item => {
                const prod = item.produk || item.product;
                const prodName = prod ? prod.name : 'Produk Tidak Tersedia';
                const prodThumb = prod ? (prod.thumbnail_url || '') : '';
                const prodSize = item.size ? `Size: ${item.size}` : '';
                const prodColor = item.color && item.color !== '-' ? `Color: ${item.color}` : '';
                
                const itemEl = document.createElement('div');
                itemEl.className = 'flex gap-4 items-center bg-slate-800/40 p-3 rounded-xl border border-slate-850';
                itemEl.innerHTML = `
                    <img src="${prodThumb}" class="w-12 h-12 rounded-lg object-cover bg-slate-700" onerror="this.src='/images/default-product.png'">
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-xs font-semibold truncate">${prodName}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">${[prodSize, prodColor].filter(Boolean).join(' | ')}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-white font-bold">Rp ${Number(item.price * item.quantity).toLocaleString('id-ID')}</p>
                        <p class="text-[9px] text-slate-500 mt-0.5">${item.quantity} x Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                    </div>
                `;
                listEl.appendChild(itemEl);
            });
        } else {
            listEl.innerHTML = '<p class="text-xs text-slate-500 text-center py-4">Tidak ada item produk</p>';
        }

        // Show/Hide Review Section
        const reviewSection = document.getElementById('od-review-section');
        const reviewViewBox = document.getElementById('od-review-view-box');
        const reviewFormBox = document.getElementById('od-review-form-box');

        if (statusLower === 'selesai') {
            reviewSection.classList.remove('hidden');
            if (order.ulasan) {
                reviewViewBox.classList.remove('hidden');
                reviewFormBox.classList.add('hidden');
                document.getElementById('od-review-view-text').textContent = `"${order.ulasan.review}"`;
                const starsContainer = document.getElementById('od-review-view-stars');
                starsContainer.innerHTML = '';
                const rating = order.ulasan.rating || 5;
                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');
                    star.className = i <= rating ? 'fa-solid fa-star' : 'fa-regular fa-star text-slate-600';
                    starsContainer.appendChild(star);
                }
            } else {
                reviewViewBox.classList.add('hidden');
                reviewFormBox.classList.remove('hidden');
                document.getElementById('review-text-input').value = '';
                setStarRating(5);
                document.getElementById('od-review-form').dataset.orderId = order.id;
            }
        } else {
            reviewSection.classList.add('hidden');
        }

        // Show/hide Refund/Return button (hanya jika status 'menunggu' dan sudah dibayar/tidak 'unpaid')
        const refundBtn = document.getElementById('od-refund-btn');
        if (order.status === 'menunggu' && order.payment_status !== 'unpaid') {
            refundBtn.classList.remove('hidden');
            refundBtn.dataset.orderId = order.id;
        } else {
            refundBtn.classList.add('hidden');
            refundBtn.removeAttribute('data-order-id');
        }

        // Show Modal
        document.getElementById('order-detail-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeOrderDetailModal() {
        document.getElementById('order-detail-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openRefundModal(orderId) {
        if (!orderId) return;
        document.getElementById('refund-order-id').value = orderId;
        document.getElementById('refund-bank-name').value = '';
        document.getElementById('refund-account-number').value = '';
        document.getElementById('refund-account-name').value = '';
        document.getElementById('refund-reason').value = '';
        
        document.getElementById('refund-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRefundModal() {
        document.getElementById('refund-modal').classList.add('hidden');
        if (document.getElementById('order-detail-modal').classList.contains('hidden')) {
            document.body.style.overflow = '';
        }
    }

    async function submitRefundRequest(event) {
        event.preventDefault();
        
        const orderId = document.getElementById('refund-order-id').value;
        const bankName = document.getElementById('refund-bank-name').value;
        const accountNumber = document.getElementById('refund-account-number').value;
        const accountName = document.getElementById('refund-account-name').value;
        const reason = document.getElementById('refund-reason').value;

        const btn = document.getElementById('refund-submit-btn');
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Mengirim...';

        try {
            const response = await fetch(`/api/pesanan/${orderId}/refund`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': APP.csrfToken
                },
                body: JSON.stringify({
                    bank_name: bankName,
                    account_number: accountNumber,
                    account_name: accountName,
                    reason: reason
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message || 'Pengembalian berhasil diajukan.', 'success');
                closeRefundModal();
                closeOrderDetailModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showToast(data.message || 'Gagal mengajukan pengembalian.', 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (error) {
            console.error(error);
            showToast('Terjadi kesalahan koneksi.', 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    function setStarRating(rating) {
        document.getElementById('review-rating-input').value = rating;
        const container = document.getElementById('star-rating-selector');
        const buttons = container.getElementsByTagName('button');
        for (let i = 0; i < buttons.length; i++) {
            const icon = buttons[i].querySelector('i');
            if (i < rating) {
                buttons[i].classList.remove('text-slate-600');
                buttons[i].classList.add('text-amber-400');
            } else {
                buttons[i].classList.remove('text-amber-400');
                buttons[i].classList.add('text-slate-600');
            }
        }
    }

    async function submitOrderReview(e) {
        e.preventDefault();
        const form = e.target;
        const orderId = form.dataset.orderId;
        if (!orderId) return;

        const rating = document.getElementById('review-rating-input').value;
        const review = document.getElementById('review-text-input').value;

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Mengirim...';

        try {
            const response = await fetch('/ulasan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    pesanan_id: orderId,
                    rating: rating,
                    review: review
                })
            });

            const res = await response.json();
            if (response.ok && res.success) {
                showToast(res.message || 'Ulasan berhasil dikirim!');
                closeOrderDetailModal();
                
                // Update local order data in memory
                const localOrder = userOrders.find(o => o.id == orderId);
                if (localOrder) {
                    localOrder.ulasan = res.data;
                }
                
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast(res.message || 'Gagal mengirim ulasan', 'error');
            }
        } catch (error) {
            console.error(error);
            showToast('Terjadi kesalahan koneksi', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Ulasan';
        }
    }

    async function uploadPaymentProof(e) {
        e.preventDefault();
        const form = e.target;
        const orderId = form.dataset.orderId;
        if (!orderId) return;

        const btn = document.getElementById('od-proof-submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Mengunggah...';

        const fd = new FormData(form);

        try {
            const response = await fetch(`/api/pesanan/${orderId}/bukti`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: fd
            });

            const res = await response.json();
            if (response.ok && res.success) {
                showToast(res.message || 'Bukti transfer berhasil diunggah!');
                closeOrderDetailModal();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast(res.message || 'Gagal mengunggah bukti transfer', 'error');
            }
        } catch (err) {
            console.error(err);
            showToast('Terjadi kesalahan koneksi', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-upload"></i> Unggah Bukti Transfer';
        }
    }
    </script>

    <script id="user-orders-data" type="application/json">
        <?php echo json_encode($orders ?? [], 15, 512) ?>
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstProduct = document.querySelector('.product-card');
            const buttons = document.querySelectorAll('#category-filter .cat-btn');
            
            if (!buttons.length) {
                filterProducts();
                document.getElementById('product-grid').style.opacity = '1';
                return;
            }

            // Default pilih semua
            let catToSelect = 'semua';

            // Jalankan filter
            setCategory(catToSelect);
            
            // Tampilkan grid
            document.getElementById('product-grid').style.opacity = '1';
        });
    <?php if(auth()->guard()->check()): ?>
        <?php
            $unpaidOrder = null;
            if (isset($orders) && count($orders) > 0) {
                $unpaidOrder = $orders->first(function($order) {
                    return in_array($order->payment_method, ['transfer', 'ewallet']) 
                        && in_array($order->payment_status, ['unpaid', 'pending'])
                        && !in_array($order->status, ['dibatalkan', 'selesai'])
                        && empty($order->payment_proof);
                });
            }
        ?>

        <?php if($unpaidOrder): ?>
        <div id="unpaid-payment-alert" class="fixed bottom-6 left-6 z-40 max-w-sm bg-[#1c1c2d]/95 backdrop-blur-md border border-amber-500/25 p-4 rounded-2xl shadow-2xl flex gap-3.5 transition-all duration-500 hover:border-amber-500/45 group animate-bounce-subtle">
            <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 flex-shrink-0 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
            </div>
            <div class="flex-1 min-w-0 space-y-1">
                <h5 class="text-xs font-bold text-white flex items-center gap-1.5">
                    Pembayaran Tertunda
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                </h5>
                <p class="text-[11px] text-slate-400 leading-normal">
                    Pesanan <span class="font-mono font-semibold text-slate-300">#<?php echo e($unpaidOrder->invoice); ?></span> belum dibayar sebesar <strong class="text-amber-400 font-mono font-bold">Rp <?php echo e(number_format($unpaidOrder->total, 0, ',', '.')); ?></strong>.
                </p>
                <div class="flex items-center gap-3 pt-1">
                    <button onclick="openOrderDetail('<?php echo e($unpaidOrder->invoice); ?>')" class="text-[11px] font-bold text-brand-400 hover:text-brand-300 transition-colors flex items-center gap-0.5">
                        Bayar Sekarang <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </button>
                    <span class="text-slate-600 text-[10px]">|</span>
                    <button onclick="document.getElementById('unpaid-payment-alert').remove()" class="text-[11px] font-bold text-slate-500 hover:text-slate-300 transition-colors">
                        Nanti Saja
                    </button>
                </div>
            </div>
            <button onclick="document.getElementById('unpaid-payment-alert').remove()" class="text-slate-600 hover:text-slate-300 transition-colors self-start" title="Tutup">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html><?php /**PATH /home/irawan/laravel/shoesmarket/UMKM/UMKM-main/resources/views/layouts/landing.blade.php ENDPATH**/ ?>