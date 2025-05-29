<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',           
        'product_id',
        'quantity',
        'total_price',
        'receipt_qr_code',
        'sale_reference',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the invoice this sale belongs to
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get unit price based on quantity
     */
    public function getUnitPriceAttribute()
    {
        return $this->quantity > 0 ? $this->total_price / $this->quantity : 0;
    }
}