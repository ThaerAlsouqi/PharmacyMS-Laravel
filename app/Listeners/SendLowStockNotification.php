<?php

namespace App\Listeners;

use App\Events\LowStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLowStockNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LowStockAlert  $event
     * @return void
     */
    public function handle(LowStockAlert $event)
    {
        //
    }
}
