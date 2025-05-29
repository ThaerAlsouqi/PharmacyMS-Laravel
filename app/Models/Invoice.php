<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'status',
        'customer_info',
        'payment_method',
        'invoice_date',
        'due_date',
        'notes',
        'qr_code_path'
    ];

    protected $casts = [
        'customer_info' => 'array',
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get all sales for this invoice
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Y') . '-';
        $lastInvoice = self::where('invoice_number', 'like', $prefix . '%')
                          ->orderBy('id', 'desc')
                          ->first();

        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, strlen($prefix)));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if invoice is overdue
     */
    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'paid';
    }

    /**
     * Get formatted customer name
     */
    public function getCustomerNameAttribute()
    {
        return $this->customer_info['name'] ?? 'Walk-in Customer';
    }

    /**
     * Get formatted customer phone
     */
    public function getCustomerPhoneAttribute()
    {
        return $this->customer_info['phone'] ?? null;
    }

    /**
     * Scope for pending invoices
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid invoices
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}