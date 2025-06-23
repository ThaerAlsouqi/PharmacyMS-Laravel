<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Notifications\{ExpiredMedicineNotification, LowStockNotification};
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PurchaseObserver
{
    public function created(Purchase $purchase)
    {
        $this->checkExpiry($purchase);
        $this->checkLowStock($purchase);
    }

    public function updating(Purchase $purchase)
    {
        if ($purchase->isDirty('expiry_date')) {
            $this->checkExpiry($purchase);
        }
        
        if ($purchase->isDirty('quantity')) {
            $this->checkLowStock($purchase);
        }
    }

    protected function checkExpiry(Purchase $purchase)
    {
        $expiry = $this->parseExpiryDate($purchase->expiry_date);

        if ($expiry->isPast()) {
            $this->notifySuperAdmins($purchase);
        }
    }

    protected function parseExpiryDate($date)
    {
        return $date instanceof Carbon ? $date : Carbon::parse($date);
    }

    protected function notifySuperAdmins(Purchase $purchase)
    {
        User::whereHas('roles', function($query) {
                $query->where('id', 2);
            })
            ->chunk(100, function($admins) use ($purchase) {
                foreach ($admins as $admin) {
                    $this->sendNotification($admin, $purchase);
                }
            });
    }

    protected function sendNotification(User $admin, Purchase $purchase)
    {
        $notificationExists = $admin->notifications()
            ->where('data->product_name', $purchase->product)
            ->where('data->title', 'Expired Product Alert')
            ->exists();

        if (!$notificationExists) {
            $admin->notify(new ExpiredMedicineNotification($purchase));
        }
    }
    
    // LOW STOCK NOTIFICATION METHOD
    protected function checkLowStock(Purchase $purchase)
    {
        if ($purchase->quantity <= $purchase->minimum_stock) {
            $this->notifySuperAdminsLowStock($purchase);
        } else {
            // Stock is now above minimum - remove any existing low stock notifications
            $this->removeExistingLowStockNotifications($purchase);
        }
    }

    protected function notifySuperAdminsLowStock(Purchase $purchase)
    {
        User::whereHas('roles', fn($q) => $q->where('id', 2))
            ->chunk(100, function($admins) use ($purchase) {
                foreach ($admins as $admin) {
                    $this->sendLowStockNotification($admin, $purchase);
                }
            });
    }

    //  NO MORE DUPLICATES
    protected function sendLowStockNotification(User $admin, Purchase $purchase)
    {
        // Step 1: Remove ALL existing low stock notifications for this product
        $admin->notifications()
            ->where('type', LowStockNotification::class)
            ->where('data->product_id', $purchase->id)
            ->delete(); // Delete old notifications completely

        // Step 2: Create fresh notification with current stock levels
        $admin->notify(new LowStockNotification($purchase));
        
        // Optional: Log for debugging
        Log::info("Low stock notification updated for {$purchase->product}: {$purchase->quantity} units left");
    }

    // Remove notifications when stock is restored
    protected function removeExistingLowStockNotifications(Purchase $purchase)
    {
        User::whereHas('roles', fn($q) => $q->where('id', 2))
            ->chunk(100, function($admins) use ($purchase) {
                foreach ($admins as $admin) {
                    $admin->notifications()
                        ->where('type', LowStockNotification::class)
                        ->where('data->product_id', $purchase->id)
                        ->delete();
                }
            });
            
        Log::info("Low stock notifications cleared for {$purchase->product} - stock restored to {$purchase->quantity}");
    }
}