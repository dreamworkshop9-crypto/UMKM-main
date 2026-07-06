<div id="auth-modal" class="fixed inset-0 bg-black/70 z-[60] hidden flex items-center justify-center p-4" onclick="closeAuthModal()">
    <div class="bg-sf-800 border border-sf-600/20 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex border-b border-sf-600/20">
            <button onclick="switchAuthTab('login')" id="tab-login" class="ptab on flex-1 py-4 text-sm font-bold text-center transition-colors">Masuk</button>
            <button onclick="switchAuthTab('register')" id="tab-register" class="ptab flex-1 py-4 text-sm font-bold text-center text-slate-500 transition-colors">Daftar</button>
        </div>
        <div id="form-login" class="p-6">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="intended" value="{{ url()->current() }}">
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label><input type="email" name="email" required placeholder="contoh@email.com" value="{{ old('email') }}" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label><input type="password" name="password" required placeholder="Masukkan password" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                @if(session('error'))<div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2">{{ session('error') }}</div>@endif
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Masuk</button>
                <p class="text-center text-sm text-slate-500">Belum punya akun? <button type="button" onclick="switchAuthTab('register')" class="text-brand-400 hover:text-brand-300 font-semibold">Daftar</button></p>
            </form>
        </div>
        <div id="form-register" class="p-6 hidden">
            <form method="POST" action="{{ route('daftar') }}" class="space-y-4">
                @csrf
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-rose-400">*</span></label><input type="text" name="name" required placeholder="Nama lengkap" value="{{ old('name') }}" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">No. WhatsApp <span class="text-rose-400">*</span></label><input type="tel" name="whatsapp" required placeholder="081234567890" value="{{ old('whatsapp') }}" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Email <span class="text-rose-400">*</span></label><input type="email" name="email" required placeholder="contoh@email.com" value="{{ old('email') }}" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-rose-400">*</span></label><input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                <div><label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password <span class="text-rose-400">*</span></label><input type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-4 py-3 bg-sf-700/50 border border-sf-600/40 rounded-xl text-white placeholder-slate-500 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"></div>
                @if(session('error'))<div class="text-xs text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg px-3 py-2">{{ session('error') }}</div>@endif
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all">Daftar Akun</button>
                <p class="text-center text-sm text-slate-500">Sudah punya akun? <button type="button" onclick="switchAuthTab('login')" class="text-brand-400 hover:text-brand-300 font-semibold">Masuk</button></p>
            </form>
        </div>
    </div>
</div>