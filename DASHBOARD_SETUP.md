# SALZA Dashboard Setup Guide

## Overview
This document describes the Laravel Blade template structure for the SALZA marketplace dashboard with Tailwind CSS styling.

## Project Structure

```
resources/
├── css/
│   └── app.css (Tailwind imports)
├── js/
│   └── app.js (JavaScript bundles)
└── views/
    ├── layouts/
    │   └── app.blade.php (Main layout template)
    ├── components/
    │   ├── sidebar.blade.php (Navigation sidebar)
    │   └── header.blade.php (Top header)
    └── dashboard/
        └── index.blade.php (Dashboard home page)
```

## Key Components

### 1. Main Layout (`layouts/app.blade.php`)
The main layout template that all pages extend. It includes:
- HTML structure with dark theme
- Vite integration for CSS/JS bundling
- Custom scrollbar styles
- Sidebar and header components
- Content section with @yield('content')

**Usage:**
```blade
@extends('layouts.app')
@section('content')
    <!-- Your content here -->
@endsection
```

### 2. Sidebar Component (`components/sidebar.blade.php`)
Navigation sidebar with 4 main sections:
- **Dashboard** - Main dashboard link
- **Data Master** - Merek, Kategori, Produk, Slider, Kupon, Data Wilayah
- **Kelola Pesanan** - Pesanan, Pembatalan, Pengembalian, Ulasan, Stok Produk
- **Pengaturan** - Data User, Data Admin, Laporan

Update links by modifying the `href` attributes.

### 3. Header Component (`components/header.blade.php`)
Top navigation bar featuring:
- Menu and notification buttons
- Admin profile avatar
- Logout button (POST form with CSRF)

### 4. Dashboard Index (`dashboard/index.blade.php`)
Home page displaying:
- 3 stat cards (Sales data and Pending Orders)
- Orders table section (empty state)

## Tailwind CSS Configuration

### Custom Colors
Edit `tailwind.config.js` to customize:
```js
colors: {
  'dashboard-dark': '#0f172a',   // Dark background
  'dashboard-card': '#1e293b',   // Card background
  'salza-purple': '#7c3aed',     // Purple accent
  'salza-blue': '#2563eb',       // Blue accent
}
```

### Plugins
- `@tailwindcss/forms` - Styled form elements

## Building & Development

### Development Mode
```bash
npm run dev
```
Starts Vite dev server with HMR

### Production Build
```bash
npm run build
```
Optimizes CSS/JS for production

## Routing

### Main Routes
- `GET /dashboard` → DashboardController@index (displays dashboard.index)
- `GET /dashboard/pesanan` → DashboardController@pesanan
- `POST /logout` → LoginController@logout

### Adding New Routes
Edit `routes/web.php` and add named routes:
```php
Route::get('/your-path', [YourController::class, 'method'])->name('your-route-name');
```

Use in views: `{{ route('your-route-name') }}`

## Creating New Pages

### 1. Create a new Blade view
```bash
touch resources/views/dashboard/your-page.blade.php
```

### 2. Add content
```blade
@extends('layouts.app')

@section('title', 'Your Page Title')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Your content -->
    </div>
@endsection
```

### 3. Create a controller method
```php
public function yourPage()
{
    return view('dashboard.your-page');
}
```

### 4. Add a route
```php
Route::get('/dashboard/your-page', [DashboardController::class, 'yourPage'])->name('your-page');
```

### 5. Link from sidebar
Edit `resources/views/components/sidebar.blade.php` and add:
```blade
<li><a href="{{ route('your-page') }}" class="flex items-center...">
    <span>Your Page</span>
</a></li>
```

## Customization Guide

### Changing Colors
1. Update `tailwind.config.js` with new color values
2. Update CSS classes in templates

### Modifying Sidebar
1. Edit `resources/views/components/sidebar.blade.php`
2. Update links and section titles
3. Customize icons (SVG)

### Adding Tables
Use similar structure to the orders table:
```blade
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
    <div class="p-6 border-b border-slate-700/50">
        <h2 class="text-lg font-semibold text-white">Table Title</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <!-- table content -->
        </table>
    </div>
</div>
```

### Adding Cards
```blade
<div class="bg-dashboard-card p-6 rounded-xl border border-slate-700/30">
    <p class="text-slate-400 text-sm">Label</p>
    <h3 class="text-2xl font-bold text-white">Value</h3>
</div>
```

## Common Tailwind Classes

### Background Colors
- `bg-dashboard-dark` - Dark background (#0f172a)
- `bg-dashboard-card` - Card background (#1e293b)
- `bg-slate-700/50` - Transparent dark slate

### Text Colors
- `text-white` - White text
- `text-slate-400` - Light gray text
- `text-slate-500` - Medium gray text

### Layout
- `flex` - Flexbox
- `grid grid-cols-3` - 3-column grid (responsive: md:grid-cols-3)
- `rounded-xl` - Large rounded corners
- `border border-slate-700/30` - Dark border

## Troubleshooting

### Styles not showing
1. Ensure Vite is running: `npm run dev`
2. Check tailwind.config.js includes the correct paths
3. Clear Tailwind cache: `npm run build`

### Routes not working
1. Verify route is named: `->name('route-name')`
2. Check controller method exists
3. Ensure view file is in correct directory

### Components not showing
1. Verify @include path is correct
2. Check component file exists
3. Use relative paths in resources/views/

## Resources

- [Laravel Blade Templating](https://laravel.com/docs/blade)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev)
- [Laravel Vite Plugin](https://github.com/laravel-vite/plugin)
