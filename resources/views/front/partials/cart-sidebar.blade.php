<div id="cart-overlay" class="fixed inset-0 bg-black/60 z-50 hidden opacity-0 transition-opacity duration-300" onclick="closeCart()"></div>
<div id="cart-sidebar" class="fixed top-0 right-0 bottom-0 w-full max-w-[440px] bg-sf-800 border-l border-sf-600/20 z-50 sidebar-slide translate-x-full flex flex-col">
    <div class="flex items-center justify-between p-5 border-b border-sf-600/20 flex-shrink-0">
        <div class="flex items-center gap-3"><div class="w-10 h-10 bg-brand-500/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-bag-shopping text-brand-400"></i></div><div><h3 class="text-lg font-bold text-white">Keranjang</h3><p id="cart-count-label" class="text-xs text-slate-500">0 item</p></div></div>
        <button onclick="closeCart()" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
    </div>
    <div id="free-ship-bar" class="hidden px-5 py-3 border-b border-sf-600/20 bg-sf-700/20 flex-shrink-0">
        <div class="flex items-center justify-between mb-2"><span class="text-xs text-slate-400"><i class="fa-solid fa-truck text-brand-400 mr-1.5"></i>Gratis ongkir</span><span id="free-ship-text" class="text-xs text-brand-400 font-semibold"></span></div>
        <div class="w-full h-1.5 bg-sf-600/30 rounded-full overflow-hidden"><div id="free-ship-progress" class="h-full bg-gradient-to-r from-brand-500 to-brand-400 rounded-full transition-all duration-500" style="width:0%"></div></div>
    </div>
    <div id="cart-items" class="flex-1 overflow-y-auto p-5 space-y-3 scrollbar-hide">
        <div id="cart-empty" class="flex flex-col items-center justify-center h-full text-center py-12"><div class="w-24 h-24 bg-sf-700/30 rounded-3xl flex items-center justify-center mb-5"><i class="fa-solid fa-bag-shopping text-4xl text-slate-600"></i></div><p class="text-slate-400 font-semibold text-lg">Keranjang masih kosong</p><p class="text-slate-600 text-sm mt-1">Yuk mulai belanja sepatu!</p><button onclick="closeCart()" class="mt-5 px-6 py-2.5 bg-brand-500/10 text-brand-400 hover:bg-brand-500/20 rounded-xl text-sm font-semibold transition-all">Jelajahi Produk</button></div>
    </div>
    <div id="cart-footer" class="hidden border-t border-sf-600/20 p-5 space-y-4 flex-shrink-0 bg-sf-800">
        <div class="flex gap-2">
            <input id="coupon-input" type="text" placeholder="Kode kupon..." class="flex-1 px-4 py-2.5 bg-sf-700/50 border border-sf-600/30 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500/30 transition-all">
            <button onclick="applyCoupon()" class="px-4 py-2.5 bg-sf-700 hover:bg-sf-600 text-slate-300 text-sm font-medium rounded-xl transition-all border border-sf-600/30">Pakai</button>
        </div>
        <div id="coupon-applied" class="hidden flex items-center justify-between px-3 py-2 bg-brand-500/10 border border-brand-500/20 rounded-lg"><span class="text-xs text-brand-300"><i class="fa-solid fa-ticket mr-1.5"></i>Kupon <span id="coupon-name">-</span> aktif</span><button onclick="removeCoupon()" class="text-brand-400 hover:text-brand-300"><i class="fa-solid fa-xmark text-xs"></i></button></div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-slate-500">Subtotal</span><span id="cart-subtotal" class="text-white font-medium">Rp 0</span></div>
            <div id="discount-row" class="hidden flex justify-between"><span class="text-brand-400">Diskon kupon</span><span id="cart-discount" class="text-brand-400 font-medium">-Rp 0</span></div>
            <div class="border-t border-sf-600/20 pt-2 flex justify-between items-center"><span class="text-white font-bold text-base">Total</span><span id="cart-total" class="text-brand-400 font-black text-xl">Rp 0</span></div>
        </div>
        <button onclick="handleCheckoutClick()" class="w-full py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/20 hover:shadow-brand-500/40 transition-all flex items-center justify-center gap-2 text-base"><i class="fa-solid fa-lock text-sm"></i> Checkout</button>
        <p class="text-center text-[11px] text-slate-600"><i class="fa-solid fa-shield-halved mr-1"></i>Transaksi aman & terenkripsi</p>
    </div>
</div>