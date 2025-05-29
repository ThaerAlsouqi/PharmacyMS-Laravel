@extends('admin.layouts.app')

@push('page-css')
<style>
.sales-container {
    background: #f8f9fc;
    padding: 15px 0;
}

.pos-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
    height: calc(100vh - 120px);
    display: flex;
    flex-direction: column;
}

.pos-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    flex-shrink: 0;
}

.pos-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.pos-body {
    padding: 20px;
    flex: 1;
    overflow-y: auto;
}

/* Scanner */
.scanner-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 0;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    overflow: hidden;
}

.scanner-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.scanner-icon {
    font-size: 24px;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
    padding: 12px;
    border-radius: 10px;
}

.scanner-header h4 {
    color: white;
    margin: 0;
    font-weight: 600;
    font-size: 18px;
    flex: 1;
}

.scanner-status {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    padding: 8px 12px;
    border-radius: 20px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-dot.ready { background: #28c76f; }
.status-dot.scanning { background: #ff9f43; }
.status-dot.success { background: #00cfe8; }
.status-dot.error { background: #ea5455; }

.status-text {
    color: white;
    font-size: 12px;
    font-weight: 500;
}

.scanner-body {
    padding: 25px;
    background: white;
}

/* Scanner Tabs */
.scanner-tabs {
    display: flex;
    background: #f8f9fc;
    border-radius: 10px;
    padding: 5px;
    margin-bottom: 20px;
    gap: 5px;
}

.tab-btn {
    flex: 1;
    background: transparent;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 14px;
}

.tab-btn.active {
    background: white;
    color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
}

/* Scanner Modes */
.scanner-mode {
    display: none;
}

.scanner-mode.active {
    display: block;
}

/* Manual Input */
.manual-input {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.barcode-input {
    flex: 1;
    padding: 12px 15px;
    border: 2px solid #e8ecef;
    border-radius: 10px;
    font-size: 16px;
    font-family: 'Courier New', monospace;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.barcode-input:focus {
    border-color: #667eea;
    background: white;
    outline: none;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.1);
}

.scan-btn {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 12px 20px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.scan-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 199, 111, 0.3);
}

.scan-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}


/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.product-card {
    background: white;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.product-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    margin: 0 auto 10px;
    background: #f8f9fc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #667eea;
}

.product-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
    line-height: 1.3;
}

.product-price {
    color: #28c76f;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 5px;
}

.product-stock {
    color: #6c757d;
    font-size: 12px;
}

/* Search Section Styling */
.search-section {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
}

.search-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.search-icon {
    font-size: 20px;
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    padding: 10px;
    border-radius: 8px;
}

.search-header h5 {
    margin: 0;
    color: #333;
    font-weight: 600;
    flex: 1;
}

.product-count {
    color: #6c757d;
    font-size: 12px;
    background: #f8f9fc;
    padding: 4px 8px;
    border-radius: 12px;
}

/* Search Controls */
.search-controls {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.search-input-group {
    position: relative;
    flex: 1;
}

.product-search-input {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid #e8ecef;
    border-radius: 10px;
    font-size: 16px;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.product-search-input:focus {
    border-color: #667eea;
    background: white;
    outline: none;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.1);
}

.search-clear-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
}

.search-clear-btn:hover {
    background: #5a6268;
}

/* Search Filters */
.search-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-select {
    padding: 8px 12px;
    border: 1px solid #e8ecef;
    border-radius: 8px;
    background: white;
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #667eea;
    outline: none;
}

.filter-reset-btn {
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.filter-reset-btn:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

/* Results Section */
.product-results {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.results-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
}

.results-text {
    font-weight: 600;
    color: #333;
}

.view-options {
    display: flex;
    gap: 5px;
}

.view-btn {
    background: transparent;
    border: 1px solid #e8ecef;
    border-radius: 6px;
    padding: 8px 10px;
    cursor: pointer;
    color: #6c757d;
    transition: all 0.3s ease;
}

.view-btn.active,
.view-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

/* Enhanced Product Grid */
.product-grid {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 15px;
}

.product-grid.list-view {
    grid-template-columns: 1fr;
}

.product-grid.list-view .product-card {
    display: flex;
    align-items: center;
    text-align: left;
    padding: 15px;
    gap: 15px;
}

.product-grid.list-view .product-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
}

.product-grid.list-view .product-info {
    flex: 1;
}

.product-grid.list-view .product-name {
    margin-bottom: 5px;
}

.product-grid.list-view .product-price {
    margin-bottom: 3px;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
    grid-column: 1 / -1;
}

.no-results i {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-results h4 {
    margin-bottom: 10px;
    color: #495057;
}

/* Search Highlighting */
.highlight {
    background-color: yellow;
    font-weight: bold;
    padding: 1px 2px;
    border-radius: 2px;
}

/* Stock Status Colors */
.stock-good {
    color: #28c76f;
}

.stock-low {
    color: #ff9f43;
}

.stock-empty {
    color: #ea5455;
}

.stock-good i,
.stock-low i,
.stock-empty i {
    margin-right: 4px;
}

.product-card.out-of-stock {
    opacity: 0.6;
    cursor: not-allowed;
    border-color: #ea5455;
    background: #ffeaea;
}

.product-card.out-of-stock:hover {
    transform: none;
    box-shadow: 0 2px 8px rgba(234, 84, 85, 0.2);
}

.out-of-stock-overlay {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #ea5455;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    z-index: 2;
}

/* Cart */
.cart-section {
    background: rgba(40, 199, 111, 0.05);
    border: 1px solid rgba(40, 199, 111, 0.1);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    max-height: 350px;
    overflow-y: auto;
}

.cart-title {
    color: #28c76f;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.cart-item {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.cart-item-info h5 {
    margin: 0 0 5px 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.cart-item-info p {
    margin: 0;
    font-size: 12px;
    color: #28c76f;
    font-weight: 600;
}

.cart-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-control {
    display: flex;
    align-items: center;
    gap: 5px;
}

.qty-btn {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 5px;
    background: #667eea;
    color: white;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-input {
    width: 50px;
    text-align: center;
    border: 1px solid #e8ecef;
    border-radius: 4px;
    padding: 5px;
    font-weight: 600;
}

.remove-btn {
    background: #ea5455;
    color: white;
    border: none;
    border-radius: 5px;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-cart {
    text-align: center;
    padding: 30px;
    color: #6c757d;
}

.empty-cart i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

/* Total Section */
.total-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-size: 16px;
}

.total-row:last-child {
    margin-bottom: 0;
    font-size: 20px;
    font-weight: 700;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Action Buttons */
.action-buttons {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 15px;
}

.btn {
    border: none;
    border-radius: 8px;
    padding: 15px 20px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-clear {
    background: #6c757d;
    color: white;
}

.btn-process {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
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

/* Alert */
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 300px;
    animation: slideIn 0.3s ease;
}

/* Beautiful Alert System */
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 24px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    align-items: center;
    min-width: 350px;
    max-width: 500px;
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.custom-alert.alert-success {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
    box-shadow: 0 8px 32px rgba(40, 199, 111, 0.4);
}

.custom-alert.alert-error {
    background: linear-gradient(135deg, #ea5455 0%, #ff6b6b 100%);
    box-shadow: 0 8px 32px rgba(234, 84, 85, 0.4);
}

.custom-alert.alert-warning {
    background: linear-gradient(135deg, #ff9f43 0%, #ffa726 100%);
    box-shadow: 0 8px 32px rgba(255, 159, 67, 0.4);
}

.custom-alert.alert-info {
    background: linear-gradient(135deg, #00cfe8 0%, #26c6da 100%);
    box-shadow: 0 8px 32px rgba(0, 207, 232, 0.4);
}

.alert-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    font-size: 14px;
    margin-left: auto;
    cursor: pointer;
    opacity: 0.8;
    transition: all 0.3s ease;
    padding: 6px 8px;
    border-radius: 6px;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-close:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

@keyframes slideInRight {
    from {
        transform: translateX(100%) scale(0.8);
        opacity: 0;
    }
    to {
        transform: translateX(0) scale(1);
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .custom-alert {
        top: 10px;
        right: 10px;
        left: 10px;
        min-width: auto;
        max-width: none;
    }
}

.alert-success { background: linear-gradient(135deg, #28c76f 0%, #48da89 100%); }
.alert-error { background: linear-gradient(135deg, #ea5455 0%, #ff6b6b 100%); }
.alert-warning { background: linear-gradient(135deg, #ff9f43 0%, #ffa726 100%); }
.alert-info { background: linear-gradient(135deg, #00cfe8 0%, #26c6da 100%); }

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Mobile Optimizations */
@media (max-width: 768px) {
    .pos-card {
        height: auto;
        max-height: none;
    }
    
    .scanner-tabs {
        flex-direction: column;
    }
    
    .manual-input {
        flex-direction: column;
    }
    
    .cart-item {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .alert {
        top: 10px;
        right: 10px;
        left: 10px;
        min-width: auto;
    }
}


</style>
@endpush

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">New Sale</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('sales.index')}}">Sales</a></li>
        <li class="breadcrumb-item active">New Sale</li>
    </ul>
</div>
@endpush

@section('content')
<div class="sales-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <!-- Product Search & Selection -->
                <div class="pos-card">
                    <div class="pos-header">
                        <h4 class="pos-title">
                            <i class="fas fa-search"></i>
                            Product Selection
                        </h4>
                    </div>
                    <div class="pos-body">
<!-- Clean Scanner Section -->
<div class="scanner-section">
    <div class="scanner-header">
        <i class="fas fa-barcode scanner-icon"></i>
        <h4>Barcode Scanner</h4>
        <div class="scanner-status" id="scannerStatus">
            <span class="status-dot ready"></span>
            <span class="status-text">Ready to scan</span>
        </div>
    </div>
    
    <div class="scanner-body">
        <!-- Single Scanner Tab (Manual Only) -->
        <div class="scanner-tabs">
            <button class="tab-btn active" onclick="switchMode('manual')" id="manualTab">
                <i class="fas fa-keyboard"></i>
                <span>Barcode Entry</span>
            </button>
        </div>

        <!-- Manual Entry Mode Only -->
        <div class="scanner-mode active" id="manualMode">
            <div class="manual-input">
                <input type="text" 
                       class="barcode-input" 
                       id="barcodeInput" 
                       placeholder="Scan barcode or type manually and press Enter"
                       autocomplete="off">
                <button class="scan-btn" onclick="scanBarcode()" id="scanBtn">
                    <i class="fas fa-plus"></i>
                    <span>Scan</span>
                </button>
            </div>
            <div style="text-align: center; color: #6c757d; font-size: 12px; margin-top: 10px;">
                💡 Use USB barcode scanner or type barcode manually | Press F1 to process sale
            </div>
        </div>
    </div>
</div>

                        <!-- Product Grid -->
                        <!-- Enhanced Product Search Section -->
<div class="search-section">
    <div class="search-header">
        <i class="fas fa-search search-icon"></i>
        <h5>Product Search</h5>
        <span class="product-count" id="productCount">Showing all products</span>
    </div>
    
    <div class="search-controls">
        <div class="search-input-group">
            <input type="text" 
                   class="product-search-input" 
                   id="productSearch" 
                   placeholder="Search products by name, category, or price..."
                   autocomplete="off">
            <button class="search-clear-btn" onclick="clearSearch()" id="clearSearchBtn" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="search-filters">
            <select class="filter-select" id="stockFilter" onchange="filterProducts()">
                <option value="all">All Stock</option>
                <option value="available">In Stock Only</option>
                <option value="low">Low Stock (≤5)</option>
                <option value="out">Out of Stock</option>
            </select>
            
            <select class="filter-select" id="priceFilter" onchange="filterProducts()">
                <option value="all">All Prices</option>
                <option value="0-10">$0 - $10</option>
                <option value="10-50">$10 - $50</option>
                <option value="50+">$50+</option>
            </select>
            
            <button class="filter-reset-btn" onclick="resetFilters()">
                <i class="fas fa-undo"></i>
                Reset
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Product Grid with Search Results -->
<div class="product-results">
    <div class="results-header">
        <span class="results-text" id="resultsText">All Products</span>
        <div class="view-options">
            <button class="view-btn active" onclick="setView('grid')" id="gridViewBtn">
                <i class="fas fa-th"></i>
            </button>
            <button class="view-btn" onclick="setView('list')" id="listViewBtn">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <div class="product-grid" id="productGrid">
        <!-- Products will be rendered here by JavaScript -->
        <div class="no-results" id="noResults" style="display: none;">
            <i class="fas fa-search"></i>
            <h4>No products found</h4>
            <p>Try adjusting your search or filters</p>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Cart Section -->
                <div class="pos-card">
                    <div class="pos-header">
                        <h4 class="pos-title">
                            <i class="fas fa-shopping-cart"></i>
                            Shopping Cart
                        </h4>
                    </div>
                    <div class="pos-body">
                        <div class="cart-section">
                            <div class="cart-title">
                                <i class="fas fa-list"></i>
                                Items (<span id="cartCount">0</span>)
                            </div>
                            <div id="cartItems">
                                <div class="empty-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    <p>No items in cart</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="total-section">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">$0.00</span>
                            </div>
                            <div class="total-row">
                                <span>Tax (0%):</span>
                                <span id="tax">$0.00</span>
                            </div>
                            <div class="total-row">
                                <span>Total:</span>
                                <span id="grandTotal">$0.00</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn btn-clear" onclick="clearCart()">
                                <i class="fas fa-trash"></i>
                                Clear
                            </button>
                            <button class="btn btn-process" onclick="processSale()">
                                <i class="fas fa-credit-card"></i>
                                Process Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-js')
<script>
// Enhanced POS System with Search - Complete Fixed Version
let cart = [];
let products = @json($products);
let filteredProducts = [...products];
let currentView = 'grid';

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 POS System Loading...');
    console.log('📦 Products loaded:', products.length);
    
    // Initialize all components
    initializeSearch();
    renderProducts();
    updateCartDisplay();
    updateProductCount();
    
    // Ensure CSRF token exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{csrf_token()}}';
        document.head.appendChild(meta);
    }
    
    // Auto-focus on barcode input
    setTimeout(() => {
        const input = document.getElementById('barcodeInput');
        if (input) {
            input.focus();
            input.select();
        }
    }, 500);
    
    updateScannerStatus('ready', 'Ready for barcode entry');
    console.log('✅ POS System Ready!');
});

// Initialize search functionality
function initializeSearch() {
    const searchInput = document.getElementById('productSearch');
    
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });

        searchInput.addEventListener('input', function() {
            const clearBtn = document.getElementById('clearSearchBtn');
            if (this.value.length > 0) {
                clearBtn.style.display = 'flex';
            } else {
                clearBtn.style.display = 'none';
            }
        });
    }
}

// Perform product search
function performSearch() {
    const searchTerm = document.getElementById('productSearch').value.toLowerCase().trim();
    const stockFilter = document.getElementById('stockFilter').value;
    const priceFilter = document.getElementById('priceFilter').value;
    
    filteredProducts = [...products];
    
    // Apply search filter
    if (searchTerm) {
        filteredProducts = filteredProducts.filter(product => {
            const productName = (product.purchase?.product || 'Unknown').toLowerCase();
            const productPrice = product.price.toString();
            return productName.includes(searchTerm) || productPrice.includes(searchTerm);
        });
    }
    
    // Apply stock filter
    if (stockFilter !== 'all') {
        filteredProducts = filteredProducts.filter(product => {
            const stock = product.purchase?.quantity || 0;
            switch(stockFilter) {
                case 'available': return stock > 0;
                case 'low': return stock > 0 && stock <= 5;
                case 'out': return stock <= 0;
                default: return true;
            }
        });
    }
    
    // Apply price filter
    if (priceFilter !== 'all') {
        filteredProducts = filteredProducts.filter(product => {
            const price = parseFloat(product.price);
            switch(priceFilter) {
                case '0-10': return price >= 0 && price <= 10;
                case '10-50': return price > 10 && price <= 50;
                case '50+': return price > 50;
                default: return true;
            }
        });
    }
    
    renderProducts();
    updateProductCount();
    updateResultsText(searchTerm);
}

// Render products in grid
// Updated renderProducts function with better data handling
function renderProducts() {
    const productGrid = document.getElementById('productGrid');
    const noResults = document.getElementById('noResults');
    
    // 🔍 DEBUG: Let's see the actual data structure
    console.log('=== PRODUCT DATA DEBUG ===');
    console.log('Total products:', filteredProducts.length);
    if (filteredProducts.length > 0) {
        console.log('First product:', filteredProducts[0]);
        console.log('Purchase data:', filteredProducts[0].purchase);
    }
    console.log('=== END DEBUG ===');
    
    if (!productGrid) {
        console.error('Product grid element not found!');
        return;
    }
    
    if (filteredProducts.length === 0) {
        productGrid.innerHTML = '';
        if (noResults) noResults.style.display = 'block';
        return;
    }
    
    if (noResults) noResults.style.display = 'none';
    
    let html = '';
    filteredProducts.forEach(product => {
        // 🔧 FIXED: Handle the actual data structure from your database
        const purchase = product.purchase;
        const stock = purchase ? purchase.quantity : 0;
        const productName = purchase ? purchase.product : 'Unknown Product';
        const productImage = purchase ? purchase.image : null;
        const barcode = purchase ? purchase.barcode : null;
        
        console.log(`Product ${product.id}:`, {
            name: productName,
            stock: stock,
            price: product.price,
            image: productImage
        });
        
        const isOutOfStock = stock <= 0;
        const isLowStock = stock > 0 && stock <= 5;
        
        let stockClass = 'stock-good';
        let stockIcon = 'fas fa-check-circle';
        let stockText = `Stock: ${stock}`;
        
        if (isOutOfStock) {
            stockClass = 'stock-empty';
            stockIcon = 'fas fa-times-circle';
            stockText = 'Out of Stock';
        } else if (isLowStock) {
            stockClass = 'stock-low';
            stockIcon = 'fas fa-exclamation-triangle';
            stockText = `Low Stock: ${stock}`;
        }
        
        html += `
            <div class="product-card ${isOutOfStock ? 'out-of-stock' : ''}" 
                 onclick="addToCart(${product.id}, '${productName.replace(/'/g, "\\'")}', ${product.price}, ${stock})"
                 title="${productName} - $${product.price} (${stockText})"
                 data-barcode="${barcode || ''}">
                
                <div class="product-image" style="position: relative;">
                    ${productImage ? 
                        `<img src="{{asset('storage/purchases/')}}/${productImage}" 
                             alt="${productName}" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                         <i class="fas fa-pills" style="display: none;"></i>` :
                        '<i class="fas fa-pills"></i>'
                    }
                    ${isOutOfStock ? '<div class="out-of-stock-overlay"><i class="fas fa-ban"></i></div>' : ''}
                </div>
                
                <div class="product-name">${highlightSearchTerm(productName)}</div>
                <div class="product-price">$${parseFloat(product.price).toFixed(2)}</div>
                <div class="product-stock ${stockClass}">
                    <i class="${stockIcon}"></i> ${stockText}
                </div>
                ${barcode ? `<div class="product-barcode" style="font-size: 10px; color: #999; margin-top: 5px;">${barcode}</div>` : ''}
            </div>
        `;
    });
    
    productGrid.innerHTML = html;
    productGrid.className = `product-grid ${currentView === 'list' ? 'list-view' : ''}`;
    console.log('🎨 Rendered', filteredProducts.length, 'products');
}

// Highlight search terms
function highlightSearchTerm(text) {
    const searchInput = document.getElementById('productSearch');
    if (!searchInput) return text;
    
    const searchTerm = searchInput.value.trim();
    if (!searchTerm) return text;
    
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}

// Update product count
function updateProductCount() {
    const productCount = document.getElementById('productCount');
    if (!productCount) return;
    
    const total = products.length;
    const showing = filteredProducts.length;
    
    if (showing === total) {
        productCount.textContent = `Showing all ${total} products`;
    } else {
        productCount.textContent = `Showing ${showing} of ${total} products`;
    }
}

// Update results text
function updateResultsText(searchTerm) {
    const resultsText = document.getElementById('resultsText');
    if (!resultsText) return;
    
    if (searchTerm) {
        resultsText.textContent = `Search results for "${searchTerm}"`;
    } else {
        resultsText.textContent = 'All Products';
    }
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('productSearch');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    if (searchInput) searchInput.value = '';
    if (clearBtn) clearBtn.style.display = 'none';
    
    performSearch();
}

// Filter products by dropdowns
function filterProducts() {
    performSearch();
}

// Reset all filters
function resetFilters() {
    const searchInput = document.getElementById('productSearch');
    const stockFilter = document.getElementById('stockFilter');
    const priceFilter = document.getElementById('priceFilter');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    if (searchInput) searchInput.value = '';
    if (stockFilter) stockFilter.value = 'all';
    if (priceFilter) priceFilter.value = 'all';
    if (clearBtn) clearBtn.style.display = 'none';
    
    filteredProducts = [...products];
    renderProducts();
    updateProductCount();
    updateResultsText('');
    
    showAlert('🔄 Filters reset', 'info');
}

// Set view mode
function setView(viewMode) {
    currentView = viewMode;
    
    // Update button states
    document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
    const viewBtn = document.getElementById(viewMode + 'ViewBtn');
    if (viewBtn) viewBtn.classList.add('active');
    
    renderProducts();
}

// Update scanner status
function updateScannerStatus(status, text) {
    const statusElement = document.getElementById('scannerStatus');
    if (statusElement) {
        const dot = statusElement.querySelector('.status-dot');
        const textElement = statusElement.querySelector('.status-text');
        
        if (dot) dot.className = `status-dot ${status}`;
        if (textElement) textElement.textContent = text;
    }
}

// Switch mode (manual only)
function switchMode(mode) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('manualTab').classList.add('active');
    
    document.querySelectorAll('.scanner-mode').forEach(m => m.classList.remove('active'));
    document.getElementById('manualMode').classList.add('active');
    
    setTimeout(() => {
        const input = document.getElementById('barcodeInput');
        if (input) {
            input.focus();
            input.select();
        }
    }, 100);
    
    updateScannerStatus('ready', 'Ready for barcode entry');
}

// Scan barcode
async function scanBarcode() {
    const input = document.getElementById('barcodeInput');
    const code = input.value.trim();
    
    if (!code) {
        showAlert('⚠️ Please enter a barcode number', 'warning');
        input.focus();
        return;
    }
    
    updateScannerStatus('scanning', 'Looking up product...');
    const scanBtn = document.getElementById('scanBtn');
    const originalText = scanBtn.innerHTML;
    scanBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Scanning...';
    scanBtn.disabled = true;
    
    try {
        console.log('🔍 Processing barcode:', code);
        
        const localProduct = products.find(p => {
            return p.purchase && p.purchase.barcode === code;
        });
        
        if (localProduct && localProduct.purchase) {
            const success = addToCart(
                localProduct.id, 
                localProduct.purchase.product, 
                localProduct.price, 
                localProduct.purchase.quantity
            );
            
            updateScannerStatus(success ? 'success' : 'error', 
                               success ? 'Product found and added!' : 'Product out of stock');
            
            input.value = '';
            input.focus();
            return;
        }
        
        // Server lookup
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await fetch('/admin/barcode/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code: code })
        });
        
        if (!response.ok) {
            throw new Error('Server error: ' + response.status);
        }
        
        const result = await response.json();
        
        if (result.success && result.data) {
            const success = addToCart(
                result.data.product_id, 
                result.data.name, 
                result.data.price, 
                result.data.stock
            );
            
            updateScannerStatus(success ? 'success' : 'error',
                               success ? 'Product found and added!' : 'Product out of stock');
        } else {
            showAlert('❌ Product not found for barcode: ' + code, 'error');
            updateScannerStatus('error', 'Product not found');
        }
        
        input.value = '';
        input.focus();
        
    } catch (error) {
        console.error('❌ Scan processing error:', error);
        showAlert('❌ Error processing barcode: ' + error.message, 'error');
        updateScannerStatus('error', 'Scan failed');
    } finally {
        scanBtn.innerHTML = originalText;
        scanBtn.disabled = false;
        
        setTimeout(() => {
            updateScannerStatus('ready', 'Ready for next barcode');
        }, 3000);
    }
}

// Add to cart
function addToCart(productId, productName, price, stock) {
    console.log('🛒 Adding to cart:', { productId, productName, price, stock });
    
    const availableStock = parseInt(stock) || 0;
    
    if (availableStock <= 0) {
        console.log('❌ Out of stock - blocking add to cart');
        showAlert('❌ ' + productName + ' is out of stock!', 'error');
        playErrorSound();
        return false;
    }
    
    let existingItem = cart.find(item => item.id == productId);
    
    if (existingItem) {
        if (existingItem.quantity >= availableStock) {
            showAlert('⚠️ Stock limit reached for ' + productName + '!', 'warning');
            playErrorSound();
            return false;
        }
        
        existingItem.quantity += 1;
        showAlert('📦 ' + productName + ' quantity updated: ' + existingItem.quantity, 'success');
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: parseFloat(price) || 0,
            quantity: 1,
            stock: availableStock
        });
        showAlert('✅ ' + productName + ' added to cart!', 'success');
    }
    
    updateCartDisplay();
    playBeep();
    return true;
}

// Sound functions
function playBeep() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.1);
    } catch (error) {
        // Ignore audio errors
    }
}

function playErrorSound() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 300;
        gainNode.gain.setValueAtTime(0.2, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.3);
    } catch (error) {
        // Ignore audio errors
    }
}

// Cart functions
function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>No items in cart</p>
                <small style="color: #999; margin-top: 10px;">
                    💡 Scan barcodes or click products to add items
                </small>
            </div>
        `;
        cartCount.textContent = '0';
    } else {
        let html = '';
        cart.forEach((item, index) => {
            const total = item.price * item.quantity;
            html += `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h5>${item.name}</h5>
                        <p>$${item.price.toFixed(2)} × ${item.quantity} = $${total.toFixed(2)}</p>
                        <small style="color: #666;">Stock: ${item.stock} available</small>
                    </div>
                    <div class="cart-controls">
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <input type="number" class="qty-input" value="${item.quantity}" 
                                   onchange="setQuantity(${index}, this.value)" 
                                   min="1" max="${item.stock}">
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="removeFromCart(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        cartItems.innerHTML = html;
        cartCount.textContent = cart.length;
    }
    
    updateTotals();
}

function updateQuantity(index, change) {
    const item = cart[index];
    const newQty = item.quantity + change;
    
    if (newQty <= 0) {
        removeFromCart(index);
    } else if (newQty > item.stock) {
        showAlert('⚠️ Stock limit reached!', 'warning');
    } else {
        item.quantity = newQty;
        updateCartDisplay();
    }
}

function setQuantity(index, quantity) {
    const item = cart[index];
    const qty = parseInt(quantity);
    
    if (isNaN(qty) || qty <= 0) {
        removeFromCart(index);
    } else if (qty > item.stock) {
        showAlert('⚠️ Stock limit reached!', 'warning');
        item.quantity = item.stock;
        updateCartDisplay();
    } else {
        item.quantity = qty;
        updateCartDisplay();
    }
}

function removeFromCart(index) {
    const itemName = cart[index].name;
    cart.splice(index, 1);
    updateCartDisplay();
    showAlert('🗑️ ' + itemName + ' removed', 'info');
}

function clearCart() {
    if (cart.length > 0 && confirm('Clear cart?')) {
        cart = [];
        updateCartDisplay();
        showAlert('🗑️ Cart cleared', 'info');
        
        setTimeout(() => {
            const input = document.getElementById('barcodeInput');
            if (input) input.focus();
        }, 500);
    }
}

function updateTotals() {
    let subtotal = 0;
    cart.forEach(item => {
        subtotal += item.price * item.quantity;
    });
    
    const tax = 0;
    const grandTotal = subtotal + tax;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('tax').textContent = '$' + tax.toFixed(2);
    document.getElementById('grandTotal').textContent = '$' + grandTotal.toFixed(2);
    
    document.title = cart.length > 0 ? 
        `Sale ($${grandTotal.toFixed(2)}) - Pharmacy POS` : 
        'New Sale - Pharmacy POS';
}

// Updated Process Sale Function for POS System
async function processSale() {
    if (cart.length === 0) {
        showAlert('⚠️ Add items first!', 'warning');
        return;
    }
    
    const total = document.getElementById('grandTotal').textContent;
    const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    if (!confirm(`Process sale?\n\nItems: ${itemCount}\nTotal: ${total}`)) {
        return;
    }
    
    const processButton = document.querySelector('.btn-process');
    const originalContent = processButton.innerHTML;
    
    processButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    processButton.disabled = true;
    
    try {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Create invoice with all cart items
        const invoiceData = {
            customer_name: 'Walk-in Customer', // You can add customer input if needed
            customer_phone: '',
            customer_address: '',
            products: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            })),
            tax_rate: 0,
            discount_amount: 0,
            payment_method: 'cash', // Default or ask user
            notes: `POS Sale - ${new Date().toLocaleString()}`
        };
        
        const response = await fetch('{{ route("admin.invoices.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify(invoiceData)
        });
        
        if (response.ok) {
            const result = await response.json();
            
            showAlert(`✅ Sale completed! Invoice #${result.invoice_number} created for ${total}`, 'success');
            cart = [];
            updateCartDisplay();
            
            // Optionally redirect to invoice or print
            setTimeout(() => {
                if (confirm('Sale completed! Do you want to print the receipt?')) {
                    window.open(`/admin/invoices/${result.invoice_id}/print`, '_blank');
                }
                // Reset for next sale
                location.reload();
            }, 2000);
            
        } else {
            throw new Error('Failed to process sale');
        }
        
    } catch (error) {
        console.error('Sale processing error:', error);
        showAlert('❌ Error: ' + error.message, 'error');
    } finally {
        processButton.innerHTML = originalContent;
        processButton.disabled = false;
    }
}

// Alert system
function showAlert(message, type = 'success') {
    const existingAlert = document.querySelector('.custom-alert');
    if (existingAlert) {
        existingAlert.remove();
    }

    const alert = document.createElement('div');
    alert.className = `custom-alert alert-${type}`;
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-triangle',
        warning: 'fas fa-exclamation-circle',
        info: 'fas fa-info-circle'
    };

    alert.innerHTML = `
        <i class="${icons[type]}" style="margin-right: 10px;"></i>
        ${message.replace(/\n/g, '<br>')}
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(alert);

    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 4000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.target.id === 'barcodeInput' && e.key === 'Enter') {
        e.preventDefault();
        scanBarcode();
    }
    
    if (e.key === 'Escape') {
        const input = document.getElementById('barcodeInput');
        if (input) {
            input.focus();
            input.select();
        }
    }
    
    if (e.key === 'F1') {
        e.preventDefault();
        processSale();
    }
    
    if (e.key === 'F2') {
        e.preventDefault();
        clearCart();
    }
    
    // Ctrl+F for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        const searchInput = document.getElementById('productSearch');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
});

// Keep focus management
document.addEventListener('click', function(e) {
    if (!e.target.matches('input, button, select, textarea')) {
        setTimeout(() => {
            const input = document.getElementById('barcodeInput');
            if (input) input.focus();
        }, 100);
    }
});

console.log('🏥 Enhanced Pharmacy POS System Ready');
console.log('💡 Shortcuts: Enter=Scan, Esc=Focus, F1=Process, F2=Clear, Ctrl+F=Search');
</script>
@endpush