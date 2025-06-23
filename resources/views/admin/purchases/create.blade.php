@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Add Purchase</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{route('purchases.index')}}">Purchases</a></li>
		<li class="breadcrumb-item active">Add Purchase</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-plus mr-2"></i>
					Add New Medicine Purchase
				</h4>
			</div>
			<div class="card-body custom-edit-service">
				
				<!-- Add Medicine -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('purchases.store')}}">
					@csrf
					
					<!-- Medicine Information Section -->
					<div class="row mb-4">
						<div class="col-12">
							<h5 class="section-title mb-3">
								<i class="fas fa-pills mr-2 text-primary"></i>
								Medicine Information
							</h5>
						</div>
					</div>
					
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Medicine Name <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="product" placeholder="Enter medicine name" required>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Category <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="category" required> 
										<option value="">Select Category</option>
										@foreach ($categories as $category)
											<option value="{{$category->id}}">{{$category->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Supplier <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="supplier" required> 
										<option value="">Select Supplier</option>
										@foreach ($suppliers as $supplier)
											<option value="{{$supplier->id}}">{{$supplier->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- Purchase Details Section -->
					<div class="row mb-4">
						<div class="col-12">
							<h5 class="section-title mb-3">
								<i class="fas fa-dollar-sign mr-2 text-success"></i>
								Purchase Details
							</h5>
						</div>
					</div>
					
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Cost Price <span class="text-danger">*</span></label>
									<input class="form-control" type="number" step="0.01" name="cost_price" placeholder="0.00" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Quantity <span class="text-danger">*</span></label>
									<input class="form-control" type="number" name="quantity" placeholder="Enter quantity" required>
								</div>
							</div>
						</div>
					</div>

					<!-- Additional Information Section -->
					<div class="row mb-4">
						<div class="col-12">
							<h5 class="section-title mb-3">
								<i class="fas fa-info-circle mr-2 text-info"></i>
								Additional Information
							</h5>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Expiry Date <span class="text-danger">*</span></label>
									<input class="form-control" type="date" name="expiry_date" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Medicine Image</label>
									<input type="file" name="image" class="form-control" accept="image/*">
									<small class="form-text text-muted">Upload medicine image (PNG, JPG up to 2MB)</small>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Enhanced Barcode & Tracking Section with USB Scanner Support -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="section-title mb-3">
            <i class="fas fa-barcode mr-2 text-warning"></i>
            Barcode & Tracking Information
        </h5>
    </div>
</div>

<div class="service-fields mb-3">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <label>Product Barcode</label>
                <div class="barcode-input-container">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text scanner-icon" id="scanner-status">
                                <i class="fas fa-barcode text-primary"></i>
                            </span>
                        </div>
                        <input class="form-control barcode-scanner-input" 
                               type="text" 
                               name="barcode" 
                               placeholder="Scan barcode or enter manually..." 
                               id="barcode-input"
                               autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-success" onclick="generateBarcode()" title="Generate New Barcode">
                                <i class="fas fa-magic mr-1"></i>Generate
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="clearBarcode()" title="Clear Barcode">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Scanner Status Indicator -->
                    <div class="scanner-status-bar">
                        <div class="status-indicator" id="scanner-indicator">
                            <i class="fas fa-usb mr-2"></i>
                            <span id="scanner-text">USB Scanner Ready - Just scan the barcode!</span>
                        </div>
                    </div>
                </div>
                
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Supplier Barcode:</strong> Scan or enter the existing barcode from medicine packaging<br>
                    <i class="fas fa-lightbulb mr-1"></i>
                    <strong>No Barcode:</strong> Click "Generate" to create a new unique barcode
                </small>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="form-group">
                <label>Minimum Stock Alert</label>
                <input class="form-control" type="number" name="minimum_stock" value="5" placeholder="5" min="1">
                <small class="form-text text-muted">
                    <i class="fas fa-bell mr-1"></i>
                    Get alerts when stock falls below this number
                </small>
            </div>
        </div>
    </div>
    
    <!-- Barcode Preview & Validation -->
    <div class="row" id="barcode-preview-section" style="display: none;">
        <div class="col-12">
            <div class="barcode-preview-card">
                <div class="preview-header">
                    <i class="fas fa-eye mr-2"></i>
                    Barcode Information
                    <span class="validation-badge" id="validation-badge"></span>
                </div>
                <div class="preview-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="barcode-display" id="barcode-display"></div>
                            <div class="barcode-type" id="barcode-type">Format: CODE128</div>
                        </div>
                        <div class="col-md-6">
                            <div class="barcode-details">
                                <div class="detail-item">
                                    <strong>Status:</strong> <span id="barcode-status">Valid</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Length:</strong> <span id="barcode-length">0</span> characters
                                </div>
                                <div class="detail-item">
                                    <strong>Type:</strong> <span id="barcode-source">Manual Entry</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Barcode Input Styling */
.barcode-input-container {
    position: relative;
}

.barcode-scanner-input {
    font-family: 'Courier New', monospace;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 1px;
    padding: 12px 15px;
}

.barcode-scanner-input:focus {
    border-color: #28c76f;
    box-shadow: 0 0 0 0.2rem rgba(40, 199, 111, 0.15);
}

.scanner-icon {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border-right: none;
}

.scanner-status-bar {
    margin-top: 8px;
    padding: 8px 12px;
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(40, 199, 111, 0.05) 100%);
    border: 1px solid rgba(40, 199, 111, 0.2);
    border-radius: 6px;
    font-size: 12px;
}

.status-indicator {
    color: #28c76f;
    font-weight: 500;
}

.status-indicator.scanning {
    color: #ffc107;
    animation: pulse 1.5s infinite;
}

.status-indicator.error {
    color: #ea5455;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}

/* Barcode Preview Styling */
.barcode-preview-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    margin-top: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: #495057;
    margin-bottom: 15px;
    font-size: 14px;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 10px;
}

.validation-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.validation-badge.valid {
    background: #28c76f;
    color: white;
}

.validation-badge.invalid {
    background: #ea5455;
    color: white;
}

.validation-badge.duplicate {
    background: #ffc107;
    color: #333;
}

.barcode-display {
    background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    font-family: 'Courier New', monospace;
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 3px;
    border: 2px solid #667eea;
    color: #333;
    margin-bottom: 10px;
}

.barcode-type {
    text-align: center;
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 15px;
}

.barcode-details {
    background: #f8f9fc;
    padding: 15px;
    border-radius: 8px;
}

.barcode-details .detail-item {
    margin-bottom: 8px;
    font-size: 13px;
}

.barcode-details .detail-item:last-child {
    margin-bottom: 0;
}

/* Input Group Enhancements */
.input-group-append .btn {
    border-left: 0;
}

.btn-outline-success:hover {
    background: #28c76f;
    border-color: #28c76f;
}

.btn-outline-danger:hover {
    background: #ea5455;
    border-color: #ea5455;
}

/* Scanning Animation */
.scanning-animation {
    animation: scanEffect 2s infinite;
}

@keyframes scanEffect {
    0% { background-color: transparent; }
    50% { background-color: rgba(40, 199, 111, 0.1); }
    100% { background-color: transparent; }
}
</style>

<script>
// Enhanced Barcode Management with USB Scanner Support
class BarcodeManager {
    constructor() {
        this.input = document.getElementById('barcode-input');
        this.scannerText = document.getElementById('scanner-text');
        this.scannerIndicator = document.getElementById('scanner-indicator');
        this.isScanning = false;
        this.scanBuffer = '';
        this.scanTimeout = null;
        
        this.initializeScanner();
        this.bindEvents();
    }
    
    initializeScanner() {
        // USB Barcode Scanner Detection
        document.addEventListener('keydown', (e) => this.handleScannerInput(e));
        
        // Focus on barcode input for scanner
        this.input.addEventListener('focus', () => {
            this.updateScannerStatus('ready', 'USB Scanner Active - Ready to scan!');
        });
        
        this.input.addEventListener('blur', () => {
            this.updateScannerStatus('idle', 'USB Scanner Ready - Click to activate');
        });
    }
    
    bindEvents() {
        // Manual input detection
        this.input.addEventListener('input', (e) => {
            const value = e.target.value.trim();
            if (value.length > 0) {
                this.validateAndPreviewBarcode(value, 'manual');
            } else {
                this.hideBarcodePreview();
            }
        });
        
        // Paste event handling
        this.input.addEventListener('paste', (e) => {
            setTimeout(() => {
                const value = this.input.value.trim();
                if (value.length > 0) {
                    this.validateAndPreviewBarcode(value, 'pasted');
                }
            }, 100);
        });
    }
    
    handleScannerInput(e) {
        // Only process if barcode input is focused
        if (document.activeElement !== this.input) return;
        
        // Start scanning detection
        if (!this.isScanning) {
            this.isScanning = true;
            this.scanBuffer = '';
            this.updateScannerStatus('scanning', 'Scanning barcode...');
            this.input.classList.add('scanning-animation');
        }
        
        // Clear previous timeout
        if (this.scanTimeout) {
            clearTimeout(this.scanTimeout);
        }
        
        // Add character to buffer
        if (e.key.length === 1) {
            this.scanBuffer += e.key;
        }
        
        // End scanning detection (scanner usually sends Enter at the end)
        if (e.key === 'Enter' || e.key === 'Tab') {
            e.preventDefault();
            this.completeScan();
        } else {
            // Reset after 100ms of inactivity (typical scanner speed)
            this.scanTimeout = setTimeout(() => {
                this.completeScan();
            }, 100);
        }
    }
    
    completeScan() {
        this.isScanning = false;
        this.input.classList.remove('scanning-animation');
        
        if (this.scanBuffer.length > 3) {
            this.input.value = this.scanBuffer;
            this.validateAndPreviewBarcode(this.scanBuffer, 'scanned');
            this.updateScannerStatus('success', `Scanned successfully: ${this.scanBuffer}`);
            
            // Auto-focus next input after successful scan
            setTimeout(() => {
                const nextInput = this.getNextRequiredInput();
                if (nextInput) {
                    nextInput.focus();
                }
            }, 500);
        } else {
            this.updateScannerStatus('error', 'Scan failed - Please try again');
        }
        
        this.scanBuffer = '';
        if (this.scanTimeout) {
            clearTimeout(this.scanTimeout);
        }
    }
    
    validateAndPreviewBarcode(barcode, source) {
        const validation = this.validateBarcode(barcode);
        this.showBarcodePreview(barcode, validation, source);
        
        // Update input styling based on validation
        this.input.classList.remove('is-valid', 'is-invalid');
        if (validation.isValid) {
            this.input.classList.add('is-valid');
        } else {
            this.input.classList.add('is-invalid');
        }
    }
    
    validateBarcode(barcode) {
        const validation = {
            isValid: false,
            status: 'Invalid',
            reason: '',
            isDuplicate: false
        };
        
        // Basic validation
        if (barcode.length < 4) {
            validation.reason = 'Too short (minimum 4 characters)';
            return validation;
        }
        
        if (barcode.length > 50) {
            validation.reason = 'Too long (maximum 50 characters)';
            return validation;
        }
        
        if (!/^[A-Za-z0-9\-_]+$/.test(barcode)) {
            validation.reason = 'Invalid characters (use A-Z, 0-9, -, _)';
            return validation;
        }
        
        // TODO: Check for duplicates via AJAX call to your backend
        // this.checkBarcodeExists(barcode);
        
        validation.isValid = true;
        validation.status = 'Valid';
        return validation;
    }
    
    showBarcodePreview(barcode, validation, source) {
        document.getElementById('barcode-display').textContent = barcode;
        document.getElementById('barcode-length').textContent = barcode.length;
        document.getElementById('barcode-status').textContent = validation.status;
        document.getElementById('barcode-source').textContent = this.getSourceDisplay(source);
        
        // Update validation badge
        const badge = document.getElementById('validation-badge');
        badge.textContent = validation.status;
        badge.className = `validation-badge ${validation.isValid ? 'valid' : 'invalid'}`;
        
        document.getElementById('barcode-preview-section').style.display = 'block';
    }
    
    hideBarcodePreview() {
        document.getElementById('barcode-preview-section').style.display = 'none';
        this.input.classList.remove('is-valid', 'is-invalid');
    }
    
    updateScannerStatus(type, message) {
        this.scannerText.textContent = message;
        this.scannerIndicator.className = `status-indicator ${type}`;
        
        // Auto-hide success/error messages
        if (type === 'success' || type === 'error') {
            setTimeout(() => {
                this.updateScannerStatus('ready', 'USB Scanner Ready - Just scan the barcode!');
            }, 3000);
        }
    }
    
    getSourceDisplay(source) {
        const sources = {
            'manual': 'Manual Entry',
            'scanned': 'USB Scanner',
            'pasted': 'Pasted',
            'generated': 'Auto-Generated'
        };
        return sources[source] || 'Unknown';
    }
    
    getNextRequiredInput() {
        const inputs = document.querySelectorAll('input[required], select[required]');
        const currentIndex = Array.from(inputs).indexOf(this.input);
        return inputs[currentIndex + 1] || null;
    }
}

// Global functions for buttons
function generateBarcode() {
    const randomNumber = Math.floor(10000000 + Math.random() * 90000000);
    const barcode = 'PHM' + randomNumber;
    
    const input = document.getElementById('barcode-input');
    input.value = barcode;
    
    // Trigger validation and preview
    window.barcodeManager.validateAndPreviewBarcode(barcode, 'generated');
    
    // Visual feedback
    input.classList.add('is-valid');
    window.barcodeManager.updateScannerStatus('success', `Generated new barcode: ${barcode}`);
}

function clearBarcode() {
    const input = document.getElementById('barcode-input');
    input.value = '';
    input.classList.remove('is-valid', 'is-invalid');
    window.barcodeManager.hideBarcodePreview();
    window.barcodeManager.updateScannerStatus('ready', 'USB Scanner Ready - Just scan the barcode!');
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.barcodeManager = new BarcodeManager();
    
    // Auto-focus barcode input for immediate scanning
    document.getElementById('barcode-input').focus();
});
</script>

					<div class="submit-section">
						<button class="btn btn-success submit-btn" type="submit">
							<i class="fas fa-save mr-2"></i>
							Save Purchase
						</button>
						<a href="{{route('purchases.index')}}" class="btn btn-secondary ml-2">
							<i class="fas fa-times mr-2"></i>
							Cancel
						</a>
					</div>
				</form>
				<!-- /Add Medicine -->
			</div>
		</div>
	</div>			
</div>

<style>
/* Enhanced styling that works with your existing design */
.section-title {
	font-size: 1.1rem;
	font-weight: 600;
	color: #333;
	padding-bottom: 8px;
	border-bottom: 2px solid #f0f0f0;
	display: inline-block;
}

.card-header {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
	color: white !important;
	border-radius: 15px 15px 0 0 !important;
}

.card-header h4 {
	color: white !important;
	margin: 0;
	font-weight: 600;
}

.form-group label {
	font-weight: 600;
	color: #333;
	margin-bottom: 8px;
}

.form-control {
	border: 1px solid #e0e0e0;
	border-radius: 8px;
	padding: 12px 15px;
	transition: all 0.3s ease;
}

.form-control:focus {
	border-color: #667eea;
	box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.select2-container--default .select2-selection--single {
	border: 1px solid #e0e0e0;
	border-radius: 8px;
	height: 45px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: 43px;
	padding-left: 12px;
}

.submit-btn {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
	border: none;
	border-radius: 8px;
	padding: 12px 30px;
	font-weight: 600;
	transition: all 0.3s ease;
}

.submit-btn:hover {
	transform: translateY(-2px);
	box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.service-fields {
	background: #fafbfc;
	padding: 20px;
	border-radius: 10px;
	border: 1px solid #f0f0f0;
	margin-bottom: 20px;
}

.text-primary {
	color: #667eea !important;
}

.text-success {
	color: #28c76f !important;
}

.text-info {
	color: #00cfe8 !important;
}
</style>
@endsection

@push('page-js')
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
	
	<script>
		$(document).ready(function() {
			// Initialize Select2
			$('.select2').select2({
				theme: 'default',
				width: '100%',
				placeholder: function() {
					return $(this).data('placeholder') || $(this).find('option:first').text();
				}
			});

			// Form validation
			$('form').on('submit', function(e) {
				let isValid = true;
				const requiredFields = $(this).find('[required]');
				
				requiredFields.each(function() {
					if (!$(this).val() || $(this).val().trim() === '') {
						$(this).addClass('is-invalid');
						isValid = false;
					} else {
						$(this).removeClass('is-invalid');
					}
				});

				if (!isValid) {
					e.preventDefault();
					alert('Please fill in all required fields.');
				}
			});

			// Real-time validation
			$('[required]').on('blur change', function() {
				if ($(this).val() && $(this).val().trim() !== '') {
					$(this).removeClass('is-invalid').addClass('is-valid');
				} else {
					$(this).removeClass('is-valid').addClass('is-invalid');
				}
			});
		});
	</script>
@endpush