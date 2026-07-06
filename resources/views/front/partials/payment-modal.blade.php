<div id="payment-modal" class="fixed inset-0 bg-black/80 z-[70] hidden flex items-center justify-center p-4">
    <div class="bg-sf-800 border border-sf-600/20 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-5 border-b border-sf-600/20 flex items-center justify-between">
            <h3 class="text-base font-bold text-white flex items-center gap-2"><i class="fa-solid fa-circle-check text-brand-400"></i> Instruksi Pembayaran</h3>
            <button onclick="closePaymentModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="payment-content" class="p-5"></div>
        <div class="p-5 border-t border-sf-600/20">
            <div class="flex items-center justify-between mb-3"><span class="text-sm text-slate-400">Batas waktu pembayaran</span><span id="pay-countdown" class="text-sm font-bold text-amber-400 cd-digit font-mono">14:59</span></div>
            <div class="w-full h-1.5 bg-sf-600/30 rounded-full overflow-hidden mb-4"><div id="pay-countdown-bar" class="h-full bg-gradient-to-r from-rose-500 to-amber-500 rounded-full transition-all" style="width:100%"></div></div>
            <div class="flex gap-3">
                <button onclick="checkPaymentStatus()" id="btn-check-pay" class="flex-1 py-3 bg-brand-500 hover:bg-brand-400 text-white font-bold rounded-xl transition-all text-sm"><i class="fa-solid fa-rotate mr-1.5"></i>Cek Pembayaran</button>
                <button onclick="closePaymentModal()" class="px-5 py-3 bg-sf-700 hover:bg-sf-600 text-slate-300 font-medium rounded-xl transition-all text-sm">Batal</button>
            </div>
        </div>
    </div>
</div>