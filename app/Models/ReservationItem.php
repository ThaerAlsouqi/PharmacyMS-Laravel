<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'purchase_id',  // Links to the medicine in purchases table
        'quantity',
        'unit_price',
        'subtotal'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Get medicine name through purchase
    public function getMedicineNameAttribute()
    {
        return $this->purchase->product ?? 'Unknown Medicine';
    }

    // Get category through purchase
    public function getCategoryNameAttribute()
    {
        return $this->purchase->category->name ?? 'Unknown Category';
    }

    // Get medicine image through purchase
    public function getMedicineImageAttribute()
    {
        return $this->purchase->image ?? 'images/default-medicine.jpg';
    }
}