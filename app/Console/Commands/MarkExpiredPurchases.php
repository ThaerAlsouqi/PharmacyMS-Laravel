<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Notifications\ExpiredMedicineNotification;

class MarkExpiredPurchases extends Command
{
    protected $signature = 'purchases:mark-expired';
    protected $description = 'Mark medicines as expired based on expiry date';

    public function handle()
    {
        // Update expired purchases
        $expiredPurchases = Purchase::whereDate('expiry_date', '<=', Carbon::now())
            ->where('is_expired', false)
            ->get();

        if ($expiredPurchases->isEmpty()) {
            $this->info('No expired purchases found.');
            return;
        }

        // Mark purchases as expired
        Purchase::whereIn('id', $expiredPurchases->pluck('id'))
            ->update(['is_expired' => true]);

        $this->info("Marked {$expiredPurchases->count()} purchases as expired.");

        // Notify admin
        $admin = User::role('super-admin')->first(); // Ensure 'super-admin' role exists
        if ($admin) {
            $admin->notify(new ExpiredMedicineNotification($expiredPurchases->pluck('product')->toArray()));
            $this->info('Admin notified about expired purchases.');
        } else {
            $this->warn('No admin user found to notify.');
        }
    }
}
