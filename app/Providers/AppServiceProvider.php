<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('layouts.admin', function ($view) {
            if (\Illuminate\Support\Facades\Schema::hasTable('pesanans')) {
                $count = \App\Models\Pesanan::where('status', 'menunggu')->count();
                $view->with('pendingOrdersCount', $count);
            } else {
                $view->with('pendingOrdersCount', 0);
            }
        });
    }
}
