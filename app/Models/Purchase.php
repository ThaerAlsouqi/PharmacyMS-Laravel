<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $casts = [
        'expiry_date' => 'datetime',
        'barcode_data' => 'array',    // ← ADD THIS
    ];

    protected $fillable = [
        'product',
        'category_id',
        'supplier_id',
        'cost_price',
        'quantity',
        'minimum_stock',
        'expiry_date',
        'image',
        'barcode',                   
        'qr_code',                   
        'barcode_data',              
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}