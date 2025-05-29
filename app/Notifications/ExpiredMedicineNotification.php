<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpiredMedicineNotification extends Notification
{
    use Queueable;

    protected $purchase;

    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Expired Product Alert',
            'product_name' => $this->purchase->product ?? 'Unknown Product',
            'quantity' => $this->purchase->quantity ?? 'N/A',
            'image' => $this->purchase->image ?? null,
        ];
    }
}
