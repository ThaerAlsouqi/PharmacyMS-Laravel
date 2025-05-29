<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $purchase;

    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    public function via($notifiable)
    {
        return ['database']; // Add 'mail' if you want to send email notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Low Stock Alert',
            'product_id' => $this->purchase->id,
            'product_name' => $this->purchase->medicine_name,
            'quantity' => $this->purchase->quantity,
            'minimum_stock' => $this->purchase->minimum_stock,
            'image' => $this->purchase->image ?? null,
            'message' => "{$this->purchase->medicine_name} is below minimum stock ({$this->purchase->quantity} remaining)"
        ];
    }

    // public function toMail($notifiable) 
    // {
    //     return (new MailMessage)
    //         ->subject('Low Stock Alert')
    //         ->line("Product {$this->purchase->medicine_name} is below minimum stock")
    //         ->action('View Product', url("/purchases/{$this->purchase->id}"));
    // }
}