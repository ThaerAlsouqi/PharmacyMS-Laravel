<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',  // Changed from user_id to customer_id
        'reservation_number',
        'status',
        'pharmacy_name',
        'pharmacy_address',
        'pharmacy_phone',
        'total_amount',
        'tax_amount',
        'payment_method',
        'estimated_pickup_date',
        'actual_pickup_date',
        'notes',
        'cancellation_reason'
    ];

    protected $casts = [
        'estimated_pickup_date' => 'datetime',
        'actual_pickup_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    // Methods
    public static function generateReservationNumber()
    {
        $prefix = 'MF-' . date('Y') . '-';
        $lastReservation = self::where('reservation_number', 'like', $prefix . '%')
                              ->orderBy('id', 'desc')
                              ->first();

        if ($lastReservation) {
            $lastNumber = intval(substr($lastReservation->reservation_number, strlen($prefix)));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1000; // Start from 1000
        }

        return $prefix . $newNumber;
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'warning';
            case 'ready':
                return 'success';
            case 'completed':
                return 'secondary';
            case 'cancelled':
                return 'danger';
            default:
                return 'primary';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'fas fa-clock';
            case 'ready':
                return 'fas fa-box';
            case 'completed':
                return 'fas fa-check-circle';
            case 'cancelled':
                return 'fas fa-times-circle';
            default:
                return 'fas fa-info-circle';
        }
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'ready']);
    }
}