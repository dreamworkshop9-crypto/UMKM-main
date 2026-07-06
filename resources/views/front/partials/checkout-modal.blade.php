<div id="checkout-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-end sm:items-center justify-center" onclick="closeCheckout()">
    <div class="bg-sf-800 border border-sf-600/20 rounded-t-3xl sm:rounded-2xl w-full sm:max-w-lg max-h-[95vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-5 border-b border-sf-600/20 flex-shrink-0">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fa-solid fa-credit-card text-brand-400"></i> Checkout</h3>
            <button onclick="closeCheckout()" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-sf-700/50 transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <div class="flex-1 overflow-y-auto p-5 space-y-5 scrollbar-hide">
            <div>
                <h4 class="text-sm font-bold text-white flex items-center gap-2 mb-3"><i class="fa-solid fa-location-dot text-brand-400 text-xs"></i> Alamat Pengiriman</h4>
                <textarea id="co-alamat" rows="2" placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan, Kota, Kode Pos" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all resize-none"></textarea>
                <div class="grid grid-cols-2 gap-3 mt-3">
                    <select id="co-provinsi" onchange="updateShipping()" class="px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white text-sm focus:border-brand-500 transition-all"><option value="">Pilih Provinsi</option>@foreach($provinsi ?? [] as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                    <select id="co-kurir" onchange="updateShipping()" class="px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white text-sm focus:border-brand-500 transition-all"><option value="">Pilih Kurir</option>@foreach($kurir ?? [] as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select>
                </div>
            </div>
            <div class="bg-sf-700/30 rounded-xl p-4 border border-sf-600/15">
                <h4 class="text-sm font-bold text-white mb-3">Ringkasan Pesanan</h4>
                <div id="co-summary" class="space-y-2 text-sm"></div>
                <div id="co-discount-row" class="hidden flex justify-between text-sm mt-2 pt-2 border-t border-sf-600/15"><span class="text-brand-400">Diskon</span><span id="co-discount" class="text-brand-400 font-medium">-Rp 0</span></div>
                <div class="flex justify-between text-sm mt-2 pt-2 border-t border-sf-600/15"><span class="text-slate-400">Ongkos Kirim</span><span id="co-shipping" class="text-white font-medium">Pilih lokasi & kurir</span></div>
                <div class="flex justify-between mt-3 pt-3 border-t border-sf-600/30"><span class="text-white font-bold">Total Bayar</span><span id="co-grand-total" class="text-brand-400 font-black text-xl">-</span></div>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white flex items-center gap-2 mb-3"><i class="fa-solid fa-wallet text-brand-400 text-xs"></i> Metode Pembayaran</h4>
                <div class="flex border-b border-sf-600/20 mb-4">
                    <button onclick="switchPayTab('qris')" class="ptab on flex-1 py-2.5 text-xs font-bold text-center transition-colors">QRIS</button>
                    <button onclick="switchPayTab('va')" class="ptab flex-1 py-2.5 text-xs font-bold text-center text-slate-500 transition-colors">VA</button>
                    <button onclick="switchPayTab('ewallet')" class="ptab flex-1 py-2.5 text-xs font-bold text-center text-slate-500 transition-colors">E-Wallet</button>
                    <button onclick="switchPayTab('cod')" class="ptab flex-1 py-2.5 text-xs font-bold text-center text-slate-500 transition-colors">COD</button>
                </div>
                <div id="pay-qris" class="pay-panel space-y-2">
                    <label class="pay-method sel flex items-center gap-4 px-4 py-3.5 border border-brand-500 bg-brand-500/8 rounded-xl cursor-pointer" onclick="selectPay(this,'qris','QRIS')"><div class="w-10 h-10 bg-sf-700 rounded-lg flex items-center justify-center"><i class="fa-solid fa-qrcode text-brand-400"></i></div><div class="flex-1"><p class="text-sm font-semibold text-white">QRIS</p><p class="text-xs text-slate-500">Semua aplikasi pembayaran</p></div><i class="fa-solid fa-circle-check text-brand-400"></i></label>
                </div>
                <div id="pay-va" class="pay-panel hidden space-y-2">
                    @php($vas=[['BCA','va_bca','bg-blue-500/15 text-blue-400'],['BNI','va_bni','bg-orange-500/15 text-orange-400'],['MDR','va_mandiri','bg-yellow-500/15 text-yellow-400'],['BRI','va_bri','bg-blue-500/15 text-blue-300']])
                    @foreach($vas as $v)
                    <label class="pay-method flex items-center gap-4 px-4 py-3.5 border border-sf-600/30 rounded-xl cursor-pointer" onclick="selectPay(this,'{{$v[1]}}','{{$v[0]}} VA')"><div class="w-10 h-10 {{$v[2]}} rounded-lg flex items-center justify-center text-xs font-black">{{$v[0]}}</div><div class="flex-1"><p class="text-sm font-semibold text-white">{{$v[0]}} Virtual Account</p></div><i class="fa-regular fa-circle text-slate-600"></i></label>
                    @endforeach
                </div>
                <div id="pay-ewallet" class="pay-panel hidden space-y-2">
                    @php($ews=[['GoPay','ew_gopay','text-green-400'],['OVO','ew_ovo','text-purple-400'],['DANA','ew_dana','text-sky-400'],['ShopeePay','ew_shopeepay','text-orange-400']])
                    @foreach($ews as $w)
                    <label class="pay-method flex items-center gap-4 px-4 py-3.5 border border-sf-600/30 rounded-xl cursor-pointer" onclick="selectPay(this,'{{$w[1]}}','{{$w[0]}}')"><div class="w-10 h-10 bg-sf-700 rounded-lg flex items-center justify-center"><i class="fa-solid fa-wallet {{$w[2]}} text-sm"></i></div><div class="flex-1"><p class="text-sm font-semibold text-white">{{$w[0]}}</p></div><i class="fa-regular fa-circle text-slate-600"></i></label>
                    @endforeach
                </div>
                <div id="pay-cod" class="pay-panel hidden space-y-2">
                    <label class="pay-method flex items-center gap-4 px-4 py-3.5 border border-sf-600/30 rounded-xl cursor-pointer" onclick="selectPay(this,'cod','COD')"><div class="w-10 h-10 bg-amber-500/15 rounded-lg flex items-center justify-center"><i class="fa-solid fa-hand-holding-dollar text-amber-400"></i></div><div class="flex-1"><p class="text-sm font-semibold text-white">Bayar di Tempat (COD)</p></div><i class="fa-regular fa-circle text-slate-600"></i></label>
                </div>
            </div>
            <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Catatan (opsional)</label><textarea id="co-catatan" rows="2" placeholder="Catatan tambahan..." class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all resize-none"></textarea></div>
        </div>
        <div class="p-5 border-t border-sf-600/20 flex-shrink-0 bg-sf-800">
            <button onclick="processPayment()" id="btn-pay" class="w-full py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/20 hover:shadow-brand-500/40 transition-all flex items-center justify-center gap-2 text-base"><i class="fa-solid fa-lock text-sm"></i> Bayar Sekarang</button>
            <div class="flex items-center justify-center gap-4 mt-3"><span class="text-[10px] text-slate-600"><i class="fa-solid fa-shield-halved mr-1"></i>SSL Secured</span><span class="text-[10px] text-slate-600"><i class="fa-solid fa-lock mr-1"></i>PCI DSS</span><span class="text-[10px] text-slate-600"><i class="fa-brands fa-cc-visa mr-1"></i>Visa</span><span class="text-[10px] text-slate-600"><i class="fa-brands fa-cc-mastercard mr-1"></i>Mastercard</span></div>
        </div>
    </div>
</div>