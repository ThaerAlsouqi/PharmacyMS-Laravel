<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarcodeScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'scan_type',
        'product_id',
        'sale_id',
        'user_id',
        'scan_data',
        'scanned_at'
    ];

    protected $casts = [
        'scan_data' => 'array',
        'scanned_at' => 'datetime'
    ];

    /**
     * Get the product associated with the scan
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the sale associated with the scan
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the user who performed the scan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}