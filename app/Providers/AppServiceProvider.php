<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Purchase;
use App\Observers\PurchaseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Purchase::observe(PurchaseObserver::class);

    }
}
