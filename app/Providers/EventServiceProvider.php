<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LowStockAlert;
use App\Listeners\SendLowStockNotification;
use App\Listeners\BroadcastLowStockAlert;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LowStockAlert::class => [
            SendLowStockNotification::class,    // Sends email/database notifications
            BroadcastLowStockAlert::class,      // Handles real-time broadcasting
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
