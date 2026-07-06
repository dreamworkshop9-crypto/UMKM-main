<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BrandHub')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:'#f0fdf6',100:'#dcfce9',200:'#bbf7d4',300:'#86efad',
                            400:'#4ade7f',500:'#16a34a',600:'#15803c',700:'#166533',
                            800:'#14532b',900:'#0a2e18',
                        },
                        surface: {
                            50:'#f8faf9',100:'#f1f5f3',200:'#e2ebe6',300:'#c5d7cc',
                            400:'#9bb8a5',500:'#6f9680',600:'#4e755e',700:'#3d5d4b',
                            800:'#334b3e',900:'#2b3f34',
                        },
                        panel: { bg:'#f4f7f5', card:'#ffffff', border:'#dce5df' }
                    }
                }
            }
        }
    </script>

    @yield('styles')
</head>
<body class="min-h-screen">
    @yield('content')
    @yield('scripts')
</body>
</html>