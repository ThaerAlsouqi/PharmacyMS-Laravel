<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ExpiredMedicineNotification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Mark all unread notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $notification = notify('All notifications have been marked as read.');
        return back()->with($notification);
    }

    /**
     * Mark a specific notification as read.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $message = notify('Notification has been marked as read.');
        return back()->with($message);
    }

    /**
     * Delete a specific notification.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        $message = notify('Notification has been deleted.');
        return back()->with($message);
    }

    /**
     * Delete all notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $notifications = auth()->user()->notifications;
        $notifications->delete();
        $message = notify('All notifications have been deleted.');
        return back()->with($message);
    }

    /**
     * Notify about expired items.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifyExpired()
    {
        $user = auth()->user();
        $notificationCount = 0;
        
        // Process in batches of 200 to handle large datasets efficiently
        Purchase::where('expiry_date', '<', now())->chunk(200, function ($expiredPurchases) use ($user, &$notificationCount) {
            foreach ($expiredPurchases as $purchase) {
                $alreadyNotified = $user->notifications()
                    ->where('notifiable_type', get_class($user))
                    ->where('notifiable_id', $user->id)
                    ->where('data->title', 'Expired Product Alert')
                    ->where('data->product_name', $purchase->product)
                    ->exists();
        
                if (!$alreadyNotified) {
                    try {
                        $user->notify(new ExpiredMedicineNotification($purchase));
                        $notificationCount++;
                    } catch (\Exception $e) {
                        Log::error("Failed to send notification for product {$purchase->product}: " . $e->getMessage());
                        continue;
                    }
                }
            }
        });
        
        return back()->with(notify($notificationCount > 0 
            ? "Successfully sent notifications for {$notificationCount} expired medicines."
            : "No new expired medicine notifications were needed."
        ));
    }
    /**
     * Notify about out-of-stock items.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifyOutStock()
    {
        $user = User::find(auth()->id());
        $outStockItems = Purchase::where('quantity', '<=', 0)->get();
        foreach ($outStockItems as $item) {
            $user->notifications()->create([
                'type' => 'out-stock',
                'data' => ['message' => "Item {$item->name} is out of stock."],
            ]);
        }
        $message = notify('Out-of-stock items notifications have been created.');
        return back()->with($message);
    }
}
