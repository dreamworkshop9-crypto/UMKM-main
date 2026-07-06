<div id="success-modal" class="fixed inset-0 bg-black/80 z-[70] hidden flex items-center justify-center p-4">
    <div class="bg-sf-800 border border-sf-600/20 rounded-2xl w-full max-w-sm text-center p-10 shadow-2xl">
        <div class="w-24 h-24 mx-auto bg-brand-500/15 rounded-full flex items-center justify-center mb-6 pulse-glow">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="22" stroke="#34d399" stroke-width="3"/><path d="M14 24l7 7 13-14" stroke="#34d399" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke-dasharray:100;animation:checkmark .6s ease-out .3s forwards;stroke-dashoffset:100"/></svg>
        </div>
        <h3 class="text-2xl font-black text-white mb-2">Pesanan Berhasil!</h3>
        <p class="text-sm text-slate-400 mb-1">Pembayaran telah dikonfirmasi.</p>
        <p class="text-sm text-slate-400 mb-4">Kode pesanan:</p>
        <div class="bg-sf-700/50 border border-sf-600/20 rounded-xl p-4 mb-6"><p id="invoice-number" class="text-2xl font-black text-brand-400 tracking-wider font-mono">SAL-000000</p></div>
        <button onclick="closeSuccessModal(); openAccount('pesanan');" class="block w-full py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl transition-all mb-3">Lihat Pesanan Saya</button>
        <button onclick="closeSuccessModal()" class="w-full py-3.5 border border-sf-600/40 hover:border-sf-500 text-slate-300 hover:text-white font-medium rounded-2xl transition-all">Tutup</button>
    </div>
</div>