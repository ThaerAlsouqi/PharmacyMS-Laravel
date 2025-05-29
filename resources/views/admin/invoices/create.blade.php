{{-- resources/views/admin/invoices/create.blade.php --}}
@extends('admin.layouts.app')

@push('page-css')
<style>
/* Modern Invoice Creation Styling - Matching Your Theme */
.invoice-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: none;
    margin-bottom: 30px;
    overflow: hidden;
}

.invoice-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 15px 15px 0 0;
}

.invoice-title {
    color: white !important;
    margin: 0;
    font-weight: 600;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.invoice-body {
    padding: 30px;
}

/* Customer Section */
.customer-section {
    background: rgba(102, 126, 234, 0.05);
    border: 1px solid rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
}

.section-title {
    color: #667eea;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
}

/* Product Selection */
.product-section {
    background: rgba(40, 199, 111, 0.05);
    border: 1px solid rgba(40, 199, 111, 0.1);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
}

.product-row {
    background: white;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    position: relative;
}

.product-row:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.remove-product {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ea5455;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: all 0.3s ease;
}

.remove-product:hover {
    background: #dc2626;
    transform: scale(1.1);
}

/* Form Controls */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-control {
    border: 2px solid #e8ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    background: white;
    transform: translateY(-1px);
}

.select2-container--default .select2-selection--single {
    border: 2px solid #e8ecef;
    border-radius: 8px;
    height: 48px;
    background: #fafbfc;
    transition: all 0.3s ease;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    background: white;
}

/* Invoice Summary */
.invoice-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 16px;
}

.summary-row:last-child {
    margin-bottom: 0;
    font-size: 20px;
    font-weight: 700;
    padding-top: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
}

/* Action Buttons */
.action-buttons {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 15px;
    margin-top: 30px;
}

.btn {
    border: none;
    border-radius: 8px;
    padding: 15px 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-success {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.btn-add-product {
    background: linear-gradient(135deg, #00cfe8 0%, #26c6da 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

.btn-add-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 207, 232, 0.3);
}

/* Live Calculator */
.live-calculator {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
}

.calc-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.calc-item:last-child {
    font-weight: 700;
    padding-top: 8px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Product Counter */
.product-counter {
    background: rgba(40, 199, 111, 0.1);
    color: #28c76f;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 15px;
}

/* Empty State */
.empty-products {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-products i {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .invoice-body {
        padding: 20px;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .product-row {
        padding: 15px;
    }
}
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Create Invoice</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.invoices.index')}}">Invoices</a></li>
        <li class="breadcrumb-item active">Create Invoice</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('admin.invoices.store') }}" id="invoiceForm">
            @csrf
            
            <div class="invoice-card">
                <div class="invoice-header">
                    <h4 class="invoice-title">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Create New Invoice
                    </h4>
                </div>
                <div class="invoice-body">
                    
                    <!-- Customer Information -->
                    <div class="customer-section">
                        <h5 class="section-title">
                            <i class="fas fa-user"></i>
                            Customer Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name (optional)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="customer_phone" class="form-control" placeholder="Enter phone number (optional)">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="customer_address" class="form-control" rows="2" placeholder="Enter customer address (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Selection -->
                    <div class="product-section">
                        <h5 class="section-title">
                            <i class="fas fa-pills"></i>
                            Invoice Items
                        </h5>
                        <div class="product-counter" id="productCounter">
                            <i class="fas fa-list"></i> 0 Products Added
                        </div>
                        
                        <button type="button" class="btn btn-add-product" onclick="addProductRow()">
                            <i class="fas fa-plus mr-2"></i>Add Product
                        </button>
                        
                        <div id="productRows">
                            <div class="empty-products">
                                <i class="fas fa-box-open"></i>
                                <h5>No products added yet</h5>
                                <p>Click "Add Product" to start building your invoice</p>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="invoice-summary">
                        <h5 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-calculator"></i>
                            Invoice Summary
                        </h5>
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotalAmount">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (<span id="taxRate">0</span>%):</span>
                            <span id="taxAmount">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount:</span>
                            <span id="discountAmount">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Amount:</span>
                            <span id="totalAmount">$0.00</span>
                        </div>
                    </div>

                    <!-- Invoice Settings -->
                    <div class="customer-section">
                        <h5 class="section-title">
                            <i class="fas fa-cog"></i>
                            Invoice Settings
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tax Rate (%)</label>
                                    <input type="number" name="tax_rate" class="form-control" value="0" min="0" max="100" step="0.01" onchange="calculateTotals()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Discount Amount ($)</label>
                                    <input type="number" name="discount_amount" class="form-control" value="0" min="0" step="0.01" onchange="calculateTotals()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-control">
                                        <option value="">Select Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Credit/Debit Card</option>
                                        <option value="transfer">Bank Transfer</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Add any additional notes or comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success" id="createInvoiceBtn">
                            <i class="fas fa-save"></i>
                            Create Invoice
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-js')
<script>
let productCount = 0;
let products = @json($products);

// Add product row
function addProductRow() {
    productCount++;
    const container = document.getElementById('productRows');
    const emptyState = container.querySelector('.empty-products');
    if (emptyState) emptyState.remove();
    
    const productRow = document.createElement('div');
    productRow.className = 'product-row';
    productRow.id = `product-${productCount}`;
    
    productRow.innerHTML = `
        <button type="button" class="remove-product" onclick="removeProductRow(${productCount})">
            <i class="fas fa-times"></i>
        </button>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Product *</label>
                    <select name="products[${productCount}][product_id]" class="form-control product-select" onchange="updateProductInfo(${productCount})" required>
                        <option value="">Select Product</option>
                        ${products.map(product => {
                            if (product.purchase && product.purchase.quantity > 0) {
                                return `<option value="${product.id}" data-price="${product.price}" data-stock="${product.purchase.quantity}">
                                    ${product.purchase.product} (Stock: ${product.purchase.quantity} | $${parseFloat(product.price).toFixed(2)})
                                </option>`;
                            }
                            return '';
                        }).join('')}
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="products[${productCount}][quantity]" class="form-control quantity-input" 
                           min="1" value="1" onchange="calculateRowTotal(${productCount})" required>
                    <small class="text-muted">Available: <span id="stock-${productCount}">0</span></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Unit Price</label>
                    <input type="text" class="form-control" id="price-${productCount}" readonly placeholder="$0.00">
                    <small class="text-muted">Total: <span id="total-${productCount}">$0.00</span></small>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(productRow);
    updateProductCounter();
}

// Remove product row
function removeProductRow(id) {
    const row = document.getElementById(`product-${id}`);
    if (row) {
        row.remove();
        productCount--;
        updateProductCounter();
        calculateTotals();
        
        // Show empty state if no products
        const container = document.getElementById('productRows');
        if (container.children.length === 0) {
            container.innerHTML = `
                <div class="empty-products">
                    <i class="fas fa-box-open"></i>
                    <h5>No products added yet</h5>
                    <p>Click "Add Product" to start building your invoice</p>
                </div>
            `;
        }
    }
}

// Update product info when selected
function updateProductInfo(rowId) {
    const select = document.querySelector(`select[name="products[${rowId}][product_id]"]`);
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        const price = parseFloat(option.dataset.price) || 0;
        const stock = parseInt(option.dataset.stock) || 0;
        
        document.getElementById(`price-${rowId}`).value = '$' + price.toFixed(2);
        document.getElementById(`stock-${rowId}`).textContent = stock;
        
        calculateRowTotal(rowId);
    } else {
        document.getElementById(`price-${rowId}`).value = '$0.00';
        document.getElementById(`stock-${rowId}`).textContent = '0';
        document.getElementById(`total-${rowId}`).textContent = '$0.00';
        calculateTotals();
    }
}

// Calculate row total
function calculateRowTotal(rowId) {
    const select = document.querySelector(`select[name="products[${rowId}][product_id]"]`);
    const quantityInput = document.querySelector(`input[name="products[${rowId}][quantity]"]`);
    
    if (select.value && quantityInput.value) {
        const option = select.options[select.selectedIndex];
        const price = parseFloat(option.dataset.price) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const stock = parseInt(option.dataset.stock) || 0;
        
        // Validate quantity
        if (quantity > stock) {
            alert(`Warning: Quantity (${quantity}) exceeds available stock (${stock})`);
            quantityInput.style.borderColor = '#ea5455';
        } else {
            quantityInput.style.borderColor = '#28c76f';
        }
        
        const total = price * quantity;
        document.getElementById(`total-${rowId}`).textContent = '$' + total.toFixed(2);
    }
    
    calculateTotals();
}

// Calculate invoice totals
function calculateTotals() {
    let subtotal = 0;
    
    // Sum all product totals
    document.querySelectorAll('[id^="total-"]').forEach(element => {
        const total = parseFloat(element.textContent.replace('$', '')) || 0;
        subtotal += total;
    });
    
    const taxRate = parseFloat(document.querySelector('input[name="tax_rate"]').value) || 0;
    const discountAmount = parseFloat(document.querySelector('input[name="discount_amount"]').value) || 0;
    
    const taxAmount = subtotal * (taxRate / 100);
    const totalAmount = subtotal + taxAmount - discountAmount;
    
    // Update summary
    document.getElementById('subtotalAmount').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('taxRate').textContent = taxRate.toFixed(1);
    document.getElementById('taxAmount').textContent = '$' + taxAmount.toFixed(2);
    document.getElementById('discountAmount').textContent = '$' + discountAmount.toFixed(2);
    document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
}

// Update product counter
function updateProductCounter() {
    const counter = document.getElementById('productCounter');
    const activeProducts = document.querySelectorAll('.product-row').length;
    counter.innerHTML = `<i class="fas fa-list"></i> ${activeProducts} Product${activeProducts !== 1 ? 's' : ''} Added`;
}

// Form validation
document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    const productRows = document.querySelectorAll('.product-row');
    
    if (productRows.length === 0) {
        e.preventDefault();
        alert('Please add at least one product to the invoice!');
        return false;
    }
    
    // Validate each product row
    let hasErrors = false;
    productRows.forEach(row => {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        
        if (!productSelect.value) {
            hasErrors = true;
            productSelect.style.borderColor = '#ea5455';
        }
        
        if (!quantityInput.value || quantityInput.value <= 0) {
            hasErrors = true;
            quantityInput.style.borderColor = '#ea5455';
        }
    });
    
    if (hasErrors) {
        e.preventDefault();
        alert('Please fill in all required product fields!');
        return false;
    }
    
    // Show loading state
    const btn = document.getElementById('createInvoiceBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Invoice...';
    btn.disabled = true;
    
    return true;
});

// Initialize with one product row
document.addEventListener('DOMContentLoaded', function() {
    addProductRow();
    console.log('Invoice creation form loaded with', products.length, 'products available');
});
</script>
@endpush