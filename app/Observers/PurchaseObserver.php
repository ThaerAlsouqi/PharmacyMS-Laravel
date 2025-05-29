<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Notifications\{ExpiredMedicineNotification, LowStockNotification};
use App\Models\User;
use Carbon\Carbon;

class PurchaseObserver
{
 public function created(Purchase $purchase)
    {
        $this->checkExpiry($purchase);
        $this->checkLowStock($purchase); // New method
    }

    public function updating(Purchase $purchase)
    {
        if ($purchase->isDirty('expiry_date')) {
            $this->checkExpiry($purchase);
        }
        
        if ($purchase->isDirty('quantity')) { // New check
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
        // Get all users with super-admin role (role_id = 2)
        User::whereHas('roles', function($query) {
                $query->where('id', 2); // super-admin has id=2 in your roles table
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
            ->where('data->product_name', $purchase->medicine_name)
            ->where('data->title', 'Expired Product Alert')
            ->exists();

        if (!$notificationExists) {
            $admin->notify(new ExpiredMedicineNotification($purchase));
        }
    }

    // LowStockNotification
    
    protected function checkLowStock(Purchase $purchase)
    {
        if ($purchase->quantity <= $purchase->minimum_stock) {
            $this->notifySuperAdminsLowStock($purchase);
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

    protected function sendLowStockNotification(User $admin, Purchase $purchase)
    {
        $exists = $admin->notifications()
            ->where('type', LowStockNotification::class)
            ->where('data->product_id', $purchase->id)
            ->exists();

        if (!$exists) {
            $admin->notify(new LowStockNotification($purchase));
        }
    }
    
}