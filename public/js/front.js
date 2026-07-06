const APP = {
    csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
    logged: {{ auth()->check() ? 'true' : 'false' }},
    routes: {
        keranjangIndex:  '{{ route("api.keranjang") }}',
        keranjangTambah: '{{ route("api.keranjang.tambah") }}',
        keranjangHapus:  '{{ route("api.keranjang.hapus", "ID") }}',
        keranjangUpdate: '{{ route("api.keranjang.update", "ID") }}',
        produkDetail:    '{{ route("api.produk.detail", "ID") }}',
        checkout:        '{{ route("api.checkout") }}',
    }
};

const FREE_SHIP_MIN = 200000;
const COUPONS = {{ json_encode(config('salza.coupons', ['HEMAT20' => 20, 'DISKON10' => 10, 'SALZA50K' => 50000])) }};
const SHIPPING = {{ json_encode(config('salza.shipping_rates', [])) }};

let cart = [], curCat = 'semua', shipCost = 0, payMethod = 'qris', payLabel = 'QRIS', coupon = null, couponDisc = 0, cdInterval = null;

function fmt(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
function genInv() { return 'SAL-' + Date.now().toString(36).toUpperCase() + Math.random().toString(36).substr(2, 6).toUpperCase(); }
function genVA() { return '8' + Array.from({ length: 15 }, () => Math.floor(Math.random() * 10)).join(''); }

async function api(url, method = 'GET', data = null) {
    const o = { method, headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } };
    if (method !== 'GET') { o.headers['Content-Type'] = 'application/json'; o.headers['X-CSRF-TOKEN'] = APP.csrf; o.body = JSON.stringify(data); }
    const r = await fetch(url, o); const j = await r.json();
    if (!r.ok) throw { message: j.message || 'Terjadi kesalahan', errors: j.errors };
    return j;
}

async function loadCart() {
    if (!APP.logged) { cart = JSON.parse(localStorage.getItem('salza_cart') || '[]'); updateCartUI(); return; }
    try { const r = await api(APP.routes.keranjangIndex); cart = r.data || []; updateCartUI(); } catch { cart = []; updateCartUI(); }
}

async function quickAdd(id, size) {
    if (!APP.logged) { openAuthModal('login'); showToast('Silakan masuk terlebih dahulu', 'info'); return; }
    try { const r = await api(APP.routes.keranjangTambah, 'POST', { produk_id: id, ukuran: size, qty: 1 }); cart = r.data || []; updateCartUI(); showToast('Ditambahkan ke keranjang', 'success'); } catch (e) { showToast(e.message || 'Gagal', 'error'); }
}

async function removeItem(id) { try { const r = await api(APP.routes.keranjangHapus.replace('ID', id), 'DELETE'); cart = r.data || []; updateCartUI(); } catch (e) { showToast(e.message, 'error'); } }

async function updateQty(id, d) {
    const item = cart.find(i => String(i.id) === String(id)); if (!item) return;
    if (item.qty + d <= 0) { removeItem(id); return; }
    try { const r = await api(APP.routes.keranjangUpdate.replace('ID', id), 'PUT', { qty: item.qty + d }); cart = r.data || []; updateCartUI(); } catch (e) { showToast(e.message, 'error'); }
}

function getSub() { return cart.reduce((s, i) => s + i.harga * i.qty, 0); }
function getTotalQty() { return cart.reduce((s, i) => s + i.qty, 0); }

function updateCartUI() {
    const total = getTotalQty(), badge = document.getElementById('cart-badge'), footer = document.getElementById('cart-footer'), label = document.getElementById('cart-count-label');
    if (total > 0) { badge.classList.remove('hidden'); badge.classList.add('flex'); badge.textContent = total; footer.classList.remove('hidden'); } else { badge.classList.add('hidden'); badge.classList.remove('flex'); footer.classList.add('hidden'); }
    label.textContent = total + ' item';

    const sub = getSub(), fsBar = document.getElementById('free-ship-bar');
    if (cart.length > 0) { fsBar.classList.remove('hidden'); const pct = Math.min(sub / FREE_SHIP_MIN * 100, 100); document.getElementById('free-ship-progress').style.width = pct + '%'; document.getElementById('free-ship-text').textContent = sub >= FREE_SHIP_MIN ? 'Gratis ongkir!' : 'Kurang ' + fmt(FREE_SHIP_MIN - sub); } else { fsBar.classList.add('hidden'); }

    const c = document.getElementById('cart-items');
    c.innerHTML = `<div id="cart-empty" class="${cart.length ? 'hidden' : ''} flex flex-col items-center justify-center h-full text-center py-12"><div class="w-24 h-24 bg-sf-700/30 rounded-3xl flex items-center justify-center mb-5"><i class="fa-solid fa-bag-shopping text-4xl text-slate-600"></i></div><p class="text-slate-400 font-semibold text-lg">Keranjang masih kosong</p><button onclick="closeCart()" class="mt-5 px-6 py-2.5 bg-brand-500/10 text-brand-400 hover:bg-brand-500/20 rounded-xl text-sm font-semibold transition-all">Jelajahi Produk</button></div>`
    + cart.map(i => `<div class="cart-item-enter bg-sf-700/40 rounded-xl p-3 border border-sf-600/15 hover:border-sf-600/30 transition-all"><div class="flex gap-3"><img src="${(i.foto || i.image || i.gambar || 'https://picsum.photos/seed/cart-' + (i.produk_id || '0') + '/120/120.jpg')}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0" onerror="this.src='https://picsum.photos/seed/cart-${i.produk_id}/120/120.jpg'"><div class="flex-1 min-w-0"><div class="flex justify-between items-start gap-2"><h4 class="text-sm font-bold text-white truncate">${i.nama}</h4><button onclick="removeItem('${i.id}')" class="text-slate-600 hover:text-rose-400 flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-rose-500/10 transition-all"><i class="fa-solid fa-trash-can text-xs"></i></button></div><span class="text-[11px] px-2 py-0.5 bg-sf-600/30 rounded-md text-slate-400 font-medium inline-block mt-0.5">Size ${i.ukuran || '-'}</span><p class="text-sm font-bold text-brand-400 mt-1.5">${fmt(i.harga * i.qty)}</p><div class="flex items-center gap-1.5 mt-2"><button onclick="updateQty('${i.id}',-1)" class="qty-btn w-7 h-7 bg-sf-600/40 hover:bg-sf-600 rounded-lg flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-minus"></i></button><span class="text-sm font-bold text-white w-7 text-center">${i.qty}</span><button onclick="updateQty('${i.id}',1)" class="qty-btn w-7 h-7 bg-sf-600/40 hover:bg-sf-600 rounded-lg flex items-center justify-center text-slate-400 hover:text-white text-xs"><i class="fa-solid fa-plus"></i></button></div></div></div></div>`).join('');

    document.getElementById('cart-subtotal').textContent = fmt(sub);
    document.getElementById('cart-total').textContent = fmt(Math.max(0, sub - couponDisc));
    if (couponDisc > 0) { document.getElementById('discount-row').classList.remove('hidden'); document.getElementById('cart-discount').textContent = '-' + fmt(couponDisc); } else { document.getElementById('discount-row').classList.add('hidden'); }
}

function applyCoupon() { const code = document.getElementById('coupon-input').value.trim().toUpperCase(); if (!code) return; if (COUPONS[code] !== undefined) { coupon = code; const v = COUPONS[code]; couponDisc = v < 100 ? Math.round(getSub() * v / 100) : v; document.getElementById('coupon-applied').classList.remove('hidden'); document.getElementById('coupon-name').textContent = code; document.getElementById('coupon-input').value = ''; updateCartUI(); showToast('Kupon ' + code + ' aktif!', 'success'); } else showToast('Kupon tidak valid', 'error'); }
function removeCoupon() { coupon = null; couponDisc = 0; document.getElementById('coupon-applied').classList.add('hidden'); updateCartUI(); }

function openCart() { document.getElementById('cart-overlay').classList.remove('hidden'); requestAnimationFrame(() => { document.getElementById('cart-overlay').classList.remove('opacity-0'); document.getElementById('cart-sidebar').classList.remove('translate-x-full'); }); document.body.style.overflow = 'hidden'; }
function closeCart() { document.getElementById('cart-overlay').classList.add('opacity-0'); document.getElementById('cart-sidebar').classList.add('translate-x-full'); setTimeout(() => document.getElementById('cart-overlay').classList.add('hidden'), 400); document.body.style.overflow = ''; }
function handleCheckoutClick() { if (!cart.length) return; if (!APP.logged) { closeCart(); setTimeout(() => openAuthModal('login'), 400); return; } openCheckout(); }

async function openProductModal(id) {
    const m = document.getElementById('product-modal'), c = document.getElementById('product-modal-content'); m.classList.remove('hidden'); document.body.style.overflow = 'hidden';
    c.innerHTML = '<div class="flex items-center justify-center h-64"><i class="fa-solid fa-spinner fa-spin text-brand-400 text-2xl"></i></div>';
    try {
        const r = await api(APP.routes.produkDetail.replace('ID', id)), p = r.data;
        const foto = (p.images && p.images.length > 0) ? p.images[0].url : `https://picsum.photos/seed/shoe-${p.id}/800/500.jpg`;
        // ✅ FIX: Typo "..." di class sudah dihapus dan diganti class yang benar
        c.innerHTML = `<div class="relative"><img src="${foto}" class="w-full h-64 sm:h-80 object-cover"><button onclick="closeProductModal()" class="absolute top-4 right-4 w-10 h-10 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-black/70 transition-all"><i class="fa-solid fa-xmark"></i></button><span class="absolute top-4 left-4 px-3 py-1.5 ${(p.stock||0)<=5?'bg-rose-500':'bg-brand-500'} text-white text-xs font-bold rounded-lg backdrop-blur-sm">Stok: ${p.stock||0}</span><span class="absolute top-3 right-3 px-2.5 py-1 bg-sf-700/50 text-slate-300 text-xs rounded-md backdrop-blur-sm">${p.category?.name ?? ''}</span></div><div class="p-6 sm:p-8"><p class="text-xs text-brand-400 font-bold uppercase tracking-wider mb-2">${p.brand?.name||'UMKM'}</p><h2 class="text-2xl font-black text-white mb-3">${p.name}</h2><div class="flex items-center gap-4 mb-5"><div class="flex items-center gap-1">${Array(5).fill(0).map((_,j)=>'<i class="fa-solid fa-star text-xs '+(j<Math.floor(p.rating||0)?'text-amber-400':'text-sf-600')+'"></i>').join('')}</div><span class="text-sm text-slate-400">${Number(p.rating||0).toFixed(1)}</span></div><p class="text-3xl font-black text-brand-400 mb-5">${fmt(p.price)}</p><p class="text-sm text-slate-400 leading-relaxed mb-6">${p.description||''}</p><div class="mb-6"><p class="text-sm font-bold text-white mb-3">Pilih Ukuran:</p><div class="flex flex-wrap gap-2" id="size-opt">${(p.sizes||[]).map((s,i)=>'<button type="button" onclick="pickSize(this,\''+s+'\')" class="sz px-5 py-3 border '+(i===0?'border-brand-500 bg-brand-500/10 text-brand-400':'border-sf-600/40 text-slate-400 hover:border-brand-500/50 hover:text-white')+' rounded-xl text-sm font-bold transition-all">'+s+'</button>').join('')}</div><input type="hidden" id="sel-size" value="${(p.sizes||[])[0]||''}"></div><div class="flex gap-3"><button onclick="addToCartFromModal(${p.id})" class="flex-1 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/20 transition-all flex items-center justify-center gap-2"><i class="fa-solid fa-bag-shopping"></i> Tambah ke Keranjang</button><button onclick="buyNow(${p.id})" class="px-6 py-4 border border-sf-600/40 hover:border-brand-500/50 text-slate-300 hover:text-white font-bold rounded-2xl transition-all">Beli Sekarang</button></div></div>`;
    } catch (e) { c.innerHTML = `<div class="p-10 text-center"><i class="fa-solid fa-circle-exclamation text-rose-400 text-3xl mb-4"></i><p class="text-slate-400">${e.message||'Gagal memuat'}</p><button onclick="closeProductModal()" class="mt-4 text-brand-400 text-sm font-semibold">Tutup</button></div>`; }
}
function closeProductModal() { document.getElementById('product-modal').classList.add('hidden'); document.body.style.overflow = ''; }
function pickSize(b, s) { document.getElementById('sel-size').value = s; document.querySelectorAll('#size-opt .sz').forEach(x => x.className = 'sz px-5 py-3 border border-sf-600/40 text-slate-400 hover:border-brand-500/50 hover:text-white rounded-xl text-sm font-bold transition-all'); b.className = 'sz px-5 py-3 border border-brand-500 bg-brand-500/10 text-brand-400 rounded-xl text-sm font-bold transition-all'; }
function addToCartFromModal(id) { quickAdd(id, document.getElementById('sel-size').value); closeProductModal(); }
function buyNow(id) { quickAdd(id, document.getElementById('sel-size').value); closeProductModal(); setTimeout(() => openCart(), 300); }

function openAuthModal(t) { switchAuthTab(t); document.getElementById('auth-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
function closeAuthModal() { document.getElementById('auth-modal').classList.add('hidden'); document.body.style.overflow = ''; }
function switchAuthTab(t) { document.getElementById('form-login').classList.toggle('hidden', t !== 'login'); document.getElementById('form-register').classList.toggle('hidden', t !== 'register'); document.getElementById('tab-login').classList.toggle('on', t === 'login'); document.getElementById('tab-register').classList.toggle('on', t === 'register'); document.getElementById('tab-login').classList.toggle('text-slate-500', t !== 'login'); document.getElementById('tab-register').classList.toggle('text-slate-500', t !== 'register'); }

function openCheckout() { closeCart(); setTimeout(() => { document.getElementById('checkout-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; renderCoSummary(); shipCost = 0; updateShip(); }, 400); }
function closeCheckout() { document.getElementById('checkout-modal').classList.add('hidden'); document.body.style.overflow = ''; }
function renderCoSummary() { document.getElementById('co-summary').innerHTML = cart.map(i => `<div class="flex justify-between"><span class="text-slate-400 truncate mr-4">${i.nama} <span class="text-slate-600">(x${i.qty}, ${i.ukuran || '-'})</span></span><span class="text-white font-medium flex-shrink-0">${fmt(i.harga * i.qty)}</span></div>`).join(''); if (couponDisc > 0) { document.getElementById('co-discount-row').classList.remove('hidden'); document.getElementById('co-discount').textContent = '-' + fmt(couponDisc); } else document.getElementById('co-discount-row').classList.add('hidden'); }
function updateShip() { const p = document.getElementById('co-provinsi').value, k = document.getElementById('co-kurir').value; shipCost = (p && k && SHIPPING[p]?.[k]) ? SHIPPING[p][k] : 0; if (shipCost > 0 && getSub() >= FREE_SHIP_MIN) shipCost = 0; const s = document.getElementById('co-shipping'), g = document.getElementById('co-grand-total'); if (shipCost > 0) { s.textContent = fmt(shipCost); s.className = 'text-white font-medium'; } else if (p && k && getSub() >= FREE_SHIP_MIN) { s.textContent = 'GRATIS'; s.className = 'text-brand-400 font-bold'; } else { s.textContent = 'Pilih lokasi & kurir'; s.className = 'text-slate-500 font-medium'; } const t = getSub() - couponDisc + shipCost; g.textContent = t > 0 ? fmt(t) : '-'; }

function switchPayTab(t) { document.querySelectorAll('.pay-panel').forEach(p => p.classList.add('hidden')); document.getElementById('pay-' + t).classList.remove('hidden'); const tabs = document.querySelectorAll('#checkout-modal > div > div > .ptab'); tabs.forEach(x => { x.classList.remove('on'); x.classList.add('text-slate-500'); }); const idx = ['qris', 'va', 'ewallet', 'cod'].indexOf(t); if (idx >= 0) { tabs[idx].classList.add('on'); tabs[idx].classList.remove('text-slate-500'); } const f = document.querySelector('#pay-' + t + ' .pay-method'); if (f) f.click(); }
function selectPay(el, m, l) { payMethod = m; payLabel = l; el.closest('.pay-panel').querySelectorAll('.pay-method').forEach(x => { x.classList.remove('sel'); const ic = x.querySelector('i:last-child'); if (ic) ic.className = 'fa-regular fa-circle text-slate-600'; }); el.classList.add('sel'); const ic = el.querySelector('i:last-child'); if (ic) ic.className = 'fa-solid fa-circle-check text-brand-400'; }

async function processPayment() {
    const alamat = document.getElementById('co-alamat').value.trim();
    if (!alamat || alamat.length < 10) { showToast('Alamat minimal 10 karakter', 'error'); return; }
    if (!document.getElementById('co-provinsi').value || !document.getElementById('co-kurir').value) { showToast('Pilih provinsi dan kurir', 'error'); return; }
    if (shipCost === 0 && getSub() < FREE_SHIP_MIN) { showToast('Ongkir belum terhitung', 'error'); return; }
    const btn = document.getElementById('btn-pay'); btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Memproses...';
    try {
        const data = { alamat, provinsi: document.getElementById('co-provinsi').value, kurir: document.getElementById('co-kurir').value, ongkir: shipCost, pembayaran: payMethod, catatan: document.getElementById('co-catatan').value, coupon, total: getSub() - couponDisc + shipCost };
        const r = await api(APP.routes.checkout, 'POST', data);
        if (payMethod === 'cod') { cart = []; coupon = null; couponDisc = 0; shipCost = 0; updateCartUI(); closeCheckout(); document.getElementById('invoice-number').textContent = r.data?.code || genInv(); document.getElementById('success-modal').classList.remove('hidden'); showToast('Pesanan COD berhasil!', 'success'); }
        else { closeCheckout(); if (r.data?.redirect_url) { window.open(r.data.redirect_url, '_blank'); showToast('Selesaikan pembayaran di tab baru', 'info'); } else { showPayInstruction(r.data); } }
    } catch (e) { showToast(e.errors ? Object.values(e.errors)[0][0] : (e.message || 'Gagal'), 'error'); }
    finally { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-lock text-sm"></i> Bayar Sekarang'; }
}

function showPayInstruction(d) {
    const c = document.getElementById('payment-content'), total = getSub() - couponDisc + shipCost, inv = d?.code || genInv();
    let h = '';
    if (payMethod === 'qris') h = `<div class="text-center"><p class="text-sm text-slate-400 mb-4">Scan kode QR di bawah</p><div class="w-56 h-56 mx-auto bg-white rounded-2xl p-4 mb-4 flex items-center justify-center"><canvas id="qr-canvas" width="200" height="200"></canvas></div></div>`;
    else if (payMethod.startsWith('va_')) { const va = d?.va_number || genVA(), bank = payLabel.split(' ')[0]; h = `<div class="text-center"><div class="w-16 h-16 mx-auto bg-sf-700/50 rounded-2xl flex items-center justify-center mb-4"><span class="text-xl font-black text-white">${bank}</span></div><p class="text-sm text-slate-400 mb-2">Transfer ke Virtual Account:</p><div class="bg-sf-700/50 border border-sf-600/20 rounded-xl p-4 mb-2 cursor-pointer" onclick="copyText('${va}')"><p class="text-2xl font-black text-white tracking-wider font-mono">${va}</p></div><button onclick="copyText('${va}')" class="text-xs text-brand-400 hover:text-brand-300 font-medium inline-flex items-center gap-1.5"><i class="fa-regular fa-copy"></i> Salin</button></div>`; }
    else if (payMethod.startsWith('ew_')) h = `<div class="text-center"><div class="w-16 h-16 mx-auto bg-sf-700/50 rounded-2xl flex items-center justify-center mb-4"><i class="fa-solid fa-wallet text-2xl text-brand-400"></i></div><p class="text-sm text-slate-400 mb-2">${payLabel}</p><div class="bg-sf-700/50 border border-sf-600/20 rounded-xl p-5 mb-4"><p class="text-xs text-slate-500 mb-1">Total</p><p class="text-3xl font-black text-white">${fmt(total)}</p></div></div>`;
    h += `<div class="mt-4 pt-4 border-t border-sf-600/20"><div class="flex justify-between text-xs"><span class="text-slate-500">No. Pesanan</span><span class="text-white font-mono font-bold">${inv}</span></div><div class="flex justify-between text-xs mt-1.5"><span class="text-slate-500">Metode</span><span class="text-white">${payLabel}</span></div><div class="flex justify-between text-xs mt-1.5"><span class="text-slate-500">Total</span><span class="text-brand-400 font-bold">${fmt(total)}</span></div></div>`;
    c.innerHTML = h; document.getElementById('payment-modal').classList.remove('hidden'); document.body.style.overflow = 'hidden';
    if (payMethod === 'qris') setTimeout(() => drawQR('qr-canvas'), 100);
    startCD(900, inv);
}

function drawQR(id) { const c = document.getElementById(id); if (!c) return; const x = c.getContext('2d'), s = 8; x.fillStyle = '#fff'; x.fillRect(0, 0, 200, 200); x.fillStyle = '#000'; for (let y = 0; y < 25; y++) for (let i = 0; i < 25; i++) { if ((i < 7 && y < 7) || (i > 17 && y < 7) || (i < 7 && y > 17)) { if ((i === 0 || i === 6 || y === 0 || y === 6 || (i >= 2 && i <= 4 && y >= 2 && y <= 4))) x.fillRect(i * s, y * s, s, s); } else if (Math.random() > 0.5) x.fillRect(i * s, y * s, s, s); } }

function startCD(sec, inv) { if (cdInterval) clearInterval(cdInterval); let rem = sec; const el = document.getElementById('pay-countdown'), bar = document.getElementById('pay-countdown-bar'); function tick() { if (rem <= 0) { clearInterval(cdInterval); el.textContent = '00:00'; bar.style.width = '0%'; return; } rem--; const m = Math.floor(rem / 60), s = rem % 60; el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0'); bar.style.width = (rem / sec * 100) + '%'; if (rem < 300) { el.classList.add('text-rose-400'); el.classList.remove('text-amber-400'); } } el.classList.remove('text-rose-400'); el.classList.add('text-amber-400'); cdInterval = setInterval(tick, 1000); }

function checkPaymentStatus() { const b = document.getElementById('btn-check-pay'); b.disabled = true; b.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Mengecek...'; setTimeout(() => { b.disabled = false; b.innerHTML = '<i class="fa-solid fa-rotate mr-1.5"></i>Cek Pembayaran'; if (Math.random() > 0.3) { if (cdInterval) clearInterval(cdInterval); closePaymentModal(); document.getElementById('invoice-number').textContent = document.querySelector('#payment-content .font-mono')?.textContent || genInv(); document.getElementById('success-modal').classList.remove('hidden'); cart = []; coupon = null; couponDisc = 0; updateCartUI(); showToast('Pembayaran berhasil!', 'success'); } else showToast('Belum terdeteksi. Coba lagi.', 'error'); }, 2000); }

function closePaymentModal() { if (cdInterval) { clearInterval(cdInterval); cdInterval = null; } document.getElementById('payment-modal').classList.add('hidden'); document.body.style.overflow = ''; }
function closeSuccessModal() { document.getElementById('success-modal').classList.add('hidden'); document.body.style.overflow = ''; }
function copyText(t) { navigator.clipboard.writeText(t).then(() => showToast('Disalin!', 'success')).catch(() => showToast('Gagal', 'error')); }

function setCategory(c) { curCat = c; document.querySelectorAll('.cat-btn').forEach(b => { b.className = b.dataset.cat === c ? 'cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 bg-brand-500 text-white shadow-lg shadow-brand-500/20' : 'cat-btn flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 bg-sf-700/50 text-slate-400 border border-sf-600/25 hover:border-brand-500/40 hover:text-white'; }); filterProducts(); }
function filterProducts() { const q = (document.getElementById('search-input')?.value || '').toLowerCase(); let n = 0; document.querySelectorAll('.product-card').forEach(c => { const ok = (curCat === 'semua' || c.dataset.kategori === curCat) && (!q || c.dataset.name.includes(q) || c.dataset.kategori.includes(q) || c.dataset.umkm.includes(q)); c.style.display = ok ? '' : 'none'; if (ok) n++; }); document.getElementById('empty-state').classList.toggle('hidden', n > 0); }

function toggleSearch() { const b = document.getElementById('search-bar'); b.classList.toggle('hidden'); if (!b.classList.contains('hidden')) document.getElementById('search-input').focus(); }
function toggleMobileMenu() { const m = document.getElementById('mobile-menu'); m.classList.toggle('hidden'); document.getElementById('mob-icon').className = m.classList.contains('hidden') ? 'fa-solid fa-bars' : 'fa-solid fa-xmark'; }

function showToast(msg, type = 'success') { const c = document.getElementById('toast-container'), t = document.createElement('div'); const ic = { success: 'fa-circle-check text-brand-400', error: 'fa-circle-exclamation text-rose-400', info: 'fa-circle-info text-blue-400' }, bd = { success: 'border-brand-500/30', error: 'border-rose-500/30', info: 'border-blue-500/30' }; t.className = `toast-in flex items-center gap-3 px-5 py-4 bg-sf-800 border ${bd[type]||bd.success} rounded-xl shadow-2xl max-w-sm`; t.innerHTML = `<i class="fa-solid ${ic[type]||ic.success} text-lg flex-shrink-0"></i><p class="text-sm text-slate-200">${msg}</p>`; c.appendChild(t); setTimeout(() => { t.classList.remove('toast-in'); t.classList.add('toast-out'); setTimeout(() => t.remove(), 300); }, 3500); }

const obs = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) { x.target.classList.add('vis'); obs.unobserve(x.target); } }), { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
window.addEventListener('scroll', () => { const n = document.getElementById('navbar'); if (scrollY > 50) n.classList.add('shadow-xl', 'shadow-black/20'); else n.classList.remove('shadow-xl', 'shadow-black/20'); });
document.addEventListener('click', e => { if (!e.target.closest('#dd-wrap')) { const d = document.getElementById('dd-menu'); if (d) d.classList.add('hidden'); } });

document.addEventListener('DOMContentLoaded', () => { document.querySelectorAll('.fade-up').forEach(el => obs.observe(el)); loadCart(); document.querySelectorAll('[id="flash-msg"]').forEach(el => setTimeout(() => { el.classList.add('toast-out'); setTimeout(() => el.remove(), 300); }, 5000)); });