{{-- resources/views/admin/invoices/print.blade.php --}}
@extends('admin.layouts.plain')

@push('page-css')
<style>
/* Print-Optimized Invoice Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: white;
    color: #333;
    line-height: 1.6;
}

.invoice-print {
    max-width: 210mm;
    margin: 0 auto;
    padding: 20mm;
    background: white;
    min-height: 297mm;
}

/* Header Section */
.print-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 3px solid #667eea;
}

.company-section h1 {
    color: #667eea;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 5px;
}

.company-section .tagline {
    color: #6c757d;
    font-size: 16px;
    margin-bottom: 10px;
    font-style: italic;
}

.company-section .contact-info {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.4;
}

.invoice-meta {
    text-align: right;
}

.invoice-number {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.invoice-date {
    color: #6c757d;
    font-size: 16px;
    margin-bottom: 10px;
}

.status-print {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    border: 2px solid;
}

.status-paid {
    background: rgba(40, 199, 111, 0.1);
    color: #28c76f;
    border-color: #28c76f;
}

.status-pending {
    background: rgba(255, 159, 67, 0.1);
    color: #ff9f43;
    border-color: #ff9f43;
}

/* Print Controls */
.no-print {
    display: block;
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
<div class="invoice-print">
    <!-- Print Header -->
    <div class="print-header">
        <div class="company-section">
            <h1>{{ config('app.name', 'Pharmacy') }}</h1>
            <div class="tagline">Professional Healthcare Solutions</div>
            <div class="contact-info">
                📍 Your Pharmacy Address<br>
                📞 Phone: (555) 123-4567<br>
                ✉️ Email: info@pharmacy.com
            </div>
        </div>
        <div class="invoice-meta">
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            <div class="invoice-date">{{ $invoice->invoice_date->format('M d, Y') }}</div>
            <div class="status-print status-{{ $invoice->status }}">
                {{ ucfirst($invoice->status) }}
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div style="margin-bottom: 30px;">
        <h3>Bill To:</h3>
        <p><strong>{{ $invoice->customer_name ?: 'Walk-in Customer' }}</strong></p>
        @if($invoice->customer_info['phone'] ?? null)
            <p>Phone: {{ $invoice->customer_info['phone'] }}</p>
        @endif
    </div>

    <!-- Invoice Items -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
        <thead>
            <tr style="background: #667eea; color: white;">
                <th style="padding: 15px; text-align: left;">Product</th>
                <th style="padding: 15px; text-align: center;">Qty</th>
                <th style="padding: 15px; text-align: right;">Price</th>
                <th style="padding: 15px; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->sales as $sale)
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px;">{{ $sale->product->purchase->product ?? 'Unknown' }}</td>
                <td style="padding: 15px; text-align: center;">{{ $sale->quantity }}</td>
                <td style="padding: 15px; text-align: right;">${{ number_format($sale->unit_price, 2) }}</td>
                <td style="padding: 15px; text-align: right;">${{ number_format($sale->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div style="text-align: right; margin-bottom: 30px;">
        <div style="display: inline-block; min-width: 300px; border: 2px solid #667eea; border-radius: 10px; overflow: hidden;">
            <div style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0;">
                <span>Subtotal: </span>
                <strong>${{ number_format($invoice->subtotal, 2) }}</strong>
            </div>
            @if($invoice->tax_amount > 0)
            <div style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0;">
                <span>Tax: </span>
                <strong>${{ number_format($invoice->tax_amount, 2) }}</strong>
            </div>
            @endif
            <div style="padding: 15px 20px; background: #667eea; color: white; font-size: 20px; font-weight: 700;">
                <span>Total: </span>
                <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="text-align: center; margin-top: 50px; color: #6c757d;">
        <p><strong>Thank you for choosing {{ config('app.name') }}!</strong></p>
        <p>Generated on {{ now()->format('M d, Y \a\t H:i A') }}</p>
    </div>
</div>

<!-- Print Controls -->
<div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
    <button onclick="window.print()" style="background: #667eea; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-print"></i> Print
    </button>
    <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
        <i class="fas fa-times"></i> Close
    </button>
</div>
@endsection

@push('page-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Print view loaded for invoice {{ $invoice->invoice_number }}');
});

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        window.print();
    }
    
    if (e.key === 'Escape') {
        window.close();
    }
});
</script>
@endpush