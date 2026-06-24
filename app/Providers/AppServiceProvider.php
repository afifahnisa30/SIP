<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('navigation-menu', function ($view) {
            $pendingCount = 0;
            
            if (auth()->check()) {
                $pendingCount = Order::where('user_id', auth()->id())
                                     ->where('status', 'Pending')
                                     ->count();
            }
            
            $view->with('pendingCount', $pendingCount);
        });
    }
}
