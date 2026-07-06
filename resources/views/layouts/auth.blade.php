<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SALZA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-900 font-sans flex items-center justify-center p-4">

    {{-- Background dekorasi --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-600/5 rounded-full blur-3xl"></div>
    </div>

    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl text-sm backdrop-blur-sm" id="flash-success">
        <i class="fa fa-check-circle mr-1"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl text-sm backdrop-blur-sm" id="flash-error">
        <i class="fa fa-exclamation-circle mr-1"></i> {{ session('error') }}
    </div>
    @endif

    <div class="w-full max-w-md relative z-10">
        @yield('content')
    </div>

    <script>
    setTimeout(()=>{
        document.querySelectorAll('[id^="flash-"]').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
