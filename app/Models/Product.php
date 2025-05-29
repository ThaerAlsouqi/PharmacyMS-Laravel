<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'purchase_id',
        'price',
        'margin',
        'description',
        'product_qr_code',        
        'qr_data',                
    ];

    protected $casts = [       
        'qr_data' => 'array',
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
}