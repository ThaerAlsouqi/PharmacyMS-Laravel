{{-- resources/views/admin/invoices/show.blade.php --}}
@extends('admin.layouts.app')

@push('page-css')
<style>
/* Professional Invoice Display - Matching Your Theme */
.invoice-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 30px;
}

.invoice-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    position: relative;
    overflow: hidden;
}

.invoice-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-30px, -30px) rotate(180deg); }
}

.invoice-title {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    position: relative;
    z-index: 2;
}

.company-info h2 {
    color: white;
    margin: 0 0 10px 0;
    font-size: 28px;
    font-weight: 700;
}

.company-info p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 16px;
}

.invoice-meta {
    text-align: right;
    color: white;
}

.invoice-number {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
}

.invoice-date {
    font-size: 16px;
    opacity: 0.9;
}

.status-badge {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 10px;
}

.status-paid {
    background: rgba(40, 199, 111, 0.2);
    color: #28c76f;
    border: 2px solid rgba(40, 199, 111, 0.3);
}

.status-pending {
    background: rgba(255, 159, 67, 0.2);
    color: #ff9f43;
    border: 2px solid rgba(255, 159, 67, 0.3);
}

.status-cancelled {
    background: rgba(234, 84, 85, 0.2);
    color: #ea5455;
    border: 2px solid rgba(234, 84, 85, 0.3);
}

.invoice-body {
    padding: 40px;
}

/* Customer & Billing Info */
.billing-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 2px solid #f0f0f0;
}

.info-section h4 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-section p {
    margin-bottom: 8px;
    color: #6c757d;
    font-size: 15px;
}

.info-section strong {
    color: #333;
}

/* QR Code Section */
.qr-section {
    text-align: center;
    background: #f8f9fc;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.qr-code img {
    width: 120px;
    height: 120px;
    margin-bottom: 10px;
}

/* Invoice Items Table */
.invoice-items {
    margin-bottom: 40px;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.items-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.items-table th {
    padding: 20px 15px;
    text-align: left;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.items-table tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.items-table tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

.items-table tbody tr:last-child {
    border-bottom: none;
}

.items-table td {
    padding: 20px 15px;
    vertical-align: middle;
    font-size: 15px;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    background: #f8f9fc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 20px;
}

.product-details h6 {
    margin: 0 0 5px 0;
    color: #333;
    font-weight: 600;
}

.product-details small {
    color: #6c757d;
}

.quantity-badge {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}

.price-cell {
    text-align: right;
    font-weight: 600;
    color: #333;
}

.unit-price {
    color: #6c757d;
    font-size: 14px;
}

.total-price {
    color: #28c76f;
    font-size: 18px;
    font-weight: 700;
}

/* Invoice Totals */
.invoice-totals {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 40px;
}

.totals-section {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 30px;
    min-width: 350px;
    border: 2px solid #f0f0f0;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 16px;
}

.total-row:last-child {
    margin-bottom: 0;
    font-size: 22px;
    font-weight: 700;
    padding-top: 20px;
    border-top: 2px solid #667eea;
    color: #667eea;
}

.total-label {
    color: #6c757d;
}

.total-amount {
    font-weight: 600;
    color: #333;
}

.grand-total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Notes Section */
.invoice-notes {
    background: rgba(255, 159, 67, 0.1);
    border-left: 4px solid #ff9f43;
    padding: 20px;
    border-radius: 0 10px 10px 0;
    margin-bottom: 30px;
}

.invoice-notes h5 {
    color: #ff9f43;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.invoice-notes p {
    color: #6c757d;
    margin: 0;
    line-height: 1.6;
}

/* Action Buttons */
.invoice-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    padding-top: 30px;
    border-top: 2px solid #f0f0f0;
}

.btn {
    border: none;
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ff9f43 0%, #ffa726 100%);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    color: white;
}

/* Payment Info */
.payment-info {
    background: rgba(40, 199, 111, 0.1);
    border: 1px solid rgba(40, 199, 111, 0.2);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

.payment-method {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #28c76f;
    font-weight: 600;
    font-size: 16px;
}

/* Empty State */
.no-items {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.no-items i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .billing-info {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .invoice-title {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .invoice-meta {
        text-align: center;
    }
    
    .invoice-body {
        padding: 20px;
    }
    
    .invoice-header {
        padding: 20px;
    }
    
    .items-table {
        font-size: 14px;
    }
    
    .items-table th,
    .items-table td {
        padding: 12px 8px;
    }
    
    .product-info {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    
    .totals-section {
        min-width: auto;
        width: 100%;
    }
    
    .invoice-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

/* Print Styles */
@media print {
    .invoice-actions,
    .page-header,
    .sidebar,
    .header {
        display: none !important;
    }
    
    .invoice-container {
        box-shadow: none;
        margin: 0;
    }
    
    .page-wrapper {
        margin: 0;
        padding: 0;
    }
    
    body {
        background: white !important;
    }
}
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Invoice Details</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.invoices.index')}}">Invoices</a></li>
        <li class="breadcrumb-item active">{{ $invoice->invoice_number }}</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="invoice-container">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="invoice-title">
                    <div class="company-info">
                        <h2>{{ config('app.name', 'Pharmacy') }}</h2>
                        <p>Professional Pharmacy Services</p>
                        <p>📍 Your Address Here | 📞 Your Phone Number</p>
                    </div>
                    <div class="invoice-meta">
                        <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                        <div class="invoice-date">{{ $invoice->invoice_date->format('M d, Y') }}</div>
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="invoice-body">
                <!-- Billing Information -->
                <div class="billing-info">
                    <div class="info-section">
                        <h4>
                            <i class="fas fa-user"></i>
                            Customer Information
                        </h4>
                        <p><strong>Name:</strong> {{ $invoice->customer_name ?: 'Walk-in Customer' }}</p>
                        @if($invoice->customer_info['phone'] ?? null)
                            <p><strong>Phone:</strong> {{ $invoice->customer_info['phone'] }}</p>
                        @endif
                        @if($invoice->customer_info['address'] ?? null)
                            <p><strong>Address:</strong> {{ $invoice->customer_info['address'] }}</p>
                        @endif
                    </div>
                    
                    <div class="info-section">
                        <h4>
                            <i class="fas fa-file-invoice"></i>
                            Invoice Details
                        </h4>
                        <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                        @if($invoice->due_date)
                            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                        @endif
                        @if($invoice->payment_method)
                            <p><strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method) }}</p>
                        @endif
                        <p><strong>Status:</strong> 
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- QR Code Section -->
                @if($invoice->qr_code_path)
                <div class="qr-section">
                    <div class="qr-code">
                        <img src="{{ asset('storage/' . $invoice->qr_code_path) }}" alt="Invoice QR Code">
                    </div>
                    <small class="text-muted">Scan QR code for quick invoice verification</small>
                </div>
                @endif

                <!-- Invoice Items -->
                <div class="invoice-items">
                    <h4 style="margin-bottom: 20px; color: #333; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-list"></i>
                        Invoice Items ({{ $invoice->sales->count() }})
                    </h4>
                    
                    @if($invoice->sales->count() > 0)
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->sales as $sale)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-image">
                                                @if($sale->product->purchase->image ?? null)
                                                    <img src="{{ asset('storage/purchases/' . $sale->product->purchase->image) }}" 
                                                         alt="{{ $sale->product->purchase->product }}"
                                                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <i class="fas fa-pills"></i>
                                                @endif
                                            </div>
                                            <div class="product-details">
                                                <h6>{{ $sale->product->purchase->product ?? 'Unknown Product' }}</h6>
                                                @if($sale->product->purchase->barcode ?? null)
                                                    <small>Barcode: {{ $sale->product->purchase->barcode }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantity-badge">{{ $sale->quantity }}</span>
                                    </td>
                                    <td class="price-cell">
                                        <div class="unit-price">${{ number_format($sale->unit_price, 2) }}</div>
                                    </td>
                                    <td class="price-cell">
                                        <div class="total-price">${{ number_format($sale->total_price, 2) }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-items">
                            <i class="fas fa-box-open"></i>
                            <h5>No items found</h5>
                            <p>This invoice doesn't contain any items.</p>
                        </div>
                    @endif
                </div>

                <!-- Invoice Totals -->
                <div class="invoice-totals">
                    <div class="totals-section">
                        <div class="total-row">
                            <span class="total-label">Subtotal:</span>
                            <span class="total-amount">${{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        @if($invoice->tax_amount > 0)
                        <div class="total-row">
                            <span class="total-label">Tax:</span>
                            <span class="total-amount">${{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($invoice->discount_amount > 0)
                        <div class="total-row">
                            <span class="total-label">Discount:</span>
                            <span class="total-amount">-${{ number_format($invoice->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="total-row">
                            <span class="total-label">Total Amount:</span>
                            <span class="total-amount grand-total">${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                @if($invoice->payment_method)
                <div class="payment-info">
                    <div class="payment-method">
                        <i class="fas fa-credit-card"></i>
                        Payment Method: {{ ucfirst($invoice->payment_method) }}
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($invoice->notes)
                <div class="invoice-notes">
                    <h5>
                        <i class="fas fa-sticky-note"></i>
                        Notes
                    </h5>
                    <p>{{ $invoice->notes }}</p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="invoice-actions">
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Invoices
                    </a>
                    
                    <a href="{{ route('admin.invoices.print', $invoice) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-print"></i>
                        Print Invoice
                    </a>
                    
                    @if($invoice->status === 'pending')
                    <form action="{{ route('admin.invoices.mark-paid', $invoice) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Mark this invoice as paid?')">
                            <i class="fas fa-check-circle"></i>
                            Mark as Paid
                        </button>
                    </form>
                    @endif
                    
                    <button class="btn btn-warning" onclick="downloadInvoice()">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-js')
<script>
// Download invoice as PDF (using browser print to PDF)
function downloadInvoice() {
    // Hide action buttons for clean print
    const actions = document.querySelector('.invoice-actions');
    const originalDisplay = actions.style.display;
    actions.style.display = 'none';
    
    // Trigger print dialog
    window.print();
    
    // Restore action buttons
    setTimeout(() => {
        actions.style.display = originalDisplay;
    }, 1000);
}

// Auto-focus and keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+P for print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        downloadInvoice();
    }
    
    // Escape to go back
    if (e.key === 'Escape') {
        window.location.href = '{{ route("admin.invoices.index") }}';
    }
});

console.log('📄 Invoice {{ $invoice->invoice_number }} loaded successfully');
console.log('💡 Shortcuts: Ctrl+P=Print, Escape=Back');
</script>
@endpush