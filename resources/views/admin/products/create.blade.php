@extends('admin.layouts.app')

@push('page-css')
<style>
	/* Modern Product Create Form Styling - Matching Edit Page Design */
	.card {
		border: none;
		border-radius: 15px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
		overflow: hidden;
		margin-bottom: 30px;
	}

	.card-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		color: white !important;
		padding: 20px 25px;
		border-radius: 15px 15px 0 0 !important;
	}

	.card-title {
		color: white !important;
		margin: 0;
		font-weight: 600;
		font-size: 1.2rem;
	}

	.custom-edit-service {
		padding: 30px;
	}

	.info-badge {
		background: rgba(102, 126, 234, 0.1);
		color: #667eea;
		padding: 12px 20px;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 500;
		display: inline-block;
		margin-bottom: 25px;
		border: 1px solid rgba(102, 126, 234, 0.2);
	}

	.service-fields {
		background: #fafbfc;
		padding: 25px;
		border-radius: 12px;
		border: 1px solid #f0f0f0;
		margin-bottom: 25px;
		transition: all 0.3s ease;
	}

	.service-fields:hover {
		background: white;
		box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
	}

	.price-calculator {
		background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
		border: 2px solid rgba(102, 126, 234, 0.15);
		border-radius: 15px;
		padding: 25px;
		margin-bottom: 25px;
		position: relative;
		overflow: hidden;
	}

	.price-calculator::before {
		content: '';
		position: absolute;
		top: -50%;
		right: -50%;
		width: 100px;
		height: 100px;
		background: rgba(102, 126, 234, 0.05);
		border-radius: 50%;
		animation: float 8s ease-in-out infinite;
	}

	@keyframes float {
		0%, 100% { transform: translate(0, 0) rotate(0deg); }
		50% { transform: translate(-20px, -20px) rotate(180deg); }
	}

	.calculator-title {
		font-size: 1rem;
		font-weight: 600;
		color: #667eea;
		margin-bottom: 20px;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.form-group {
		margin-bottom: 25px;
		position: relative;
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

	.form-control:hover:not(:focus) {
		border-color: #c8d0e0;
		background: white;
	}

	.form-control[readonly] {
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
		font-weight: 600 !important;
		color: #667eea !important;
		border-color: rgba(102, 126, 234, 0.2) !important;
		font-size: 16px !important;
	}

	.select2-container--default .select2-selection--single {
		border: 2px solid #e8ecef;
		border-radius: 8px;
		height: 48px;
		background: #fafbfc;
		transition: all 0.3s ease;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 44px;
		padding-left: 12px;
		color: #333;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 44px;
		right: 8px;
	}

	.select2-container--default.select2-container--focus .select2-selection--single {
		border-color: #667eea;
		box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
		background: white;
	}

	.select2-dropdown {
		border: 2px solid #e8ecef;
		border-radius: 8px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
	}

	.submit-section {
		margin-top: 30px;
		padding-top: 20px;
		border-top: 1px solid #f0f0f0;
		display: flex;
		gap: 15px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.submit-btn {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		border: none;
		border-radius: 8px;
		padding: 12px 30px;
		font-weight: 600;
		font-size: 16px;
		color: white;
		transition: all 0.3s ease;
		position: relative;
		overflow: hidden;
	}

	.cancel-btn {
		background: #6c757d;
		border: none;
		border-radius: 8px;
		padding: 12px 30px;
		font-weight: 600;
		font-size: 16px;
		color: white;
		transition: all 0.3s ease;
		text-decoration: none;
		display: inline-block;
	}

	.submit-btn::before,
	.cancel-btn::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
		transition: left 0.5s;
	}

	.submit-btn:hover::before,
	.cancel-btn:hover::before {
		left: 100%;
	}

	.submit-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
		color: white;
	}

	.cancel-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
		text-decoration: none;
		color: white;
	}

	.text-danger {
		color: #ea5455 !important;
		font-weight: bold;
	}

	.profit-indicator {
		background: rgba(40, 199, 111, 0.1);
		color: #28c76f;
		padding: 8px 16px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 600;
		display: inline-block;
		margin-top: 10px;
	}

	/* Input Icons */
	.input-group-icon {
		position: relative;
	}

	.input-group-icon .form-control {
		padding-left: 45px;
	}

	.input-group-icon .input-icon {
		position: absolute;
		left: 15px;
		top: 50%;
		transform: translateY(-50%);
		color: #667eea;
		font-size: 16px;
		z-index: 5;
	}

	/* Status indicators */
	.status-success {
		background: rgba(40, 199, 111, 0.1) !important;
		color: #28c76f !important;
		border-color: rgba(40, 199, 111, 0.2) !important;
	}

	.status-warning {
		background: rgba(255, 193, 7, 0.1) !important;
		color: #ffc107 !important;
		border-color: rgba(255, 193, 7, 0.2) !important;
	}

	.status-danger {
		background: rgba(234, 84, 85, 0.1) !important;
		color: #ea5455 !important;
		border-color: rgba(234, 84, 85, 0.2) !important;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.custom-edit-service {
			padding: 20px;
		}

		.submit-section {
			flex-direction: column;
			align-items: center;
		}

		.submit-btn,
		.cancel-btn {
			width: 100%;
			max-width: 300px;
		}
	}
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Add Product</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
		<li class="breadcrumb-item active">Add Product</li>
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
					Add New Product
				</h4>
			</div>
			<div class="card-body custom-edit-service">
				<div class="info-badge">
					<i class="fas fa-info-circle mr-2"></i>
					Select a product from your purchase inventory to add to your sales catalog
				</div>

				<!-- Add Product -->
				<form method="post" enctype="multipart/form-data" action="{{ route('products.store') }}" id="productForm">
					@csrf

					<!-- Product Selection Section -->
					<div class="service-fields">
						<h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
							<i class="fas fa-pills mr-2" style="color: #667eea;"></i>
							Product Information
						</h5>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Product <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="product" id="productSelect" required>
										<option value="">Choose a product...</option>
										@foreach ($purchases as $purchase)
											<option value="{{ $purchase->id }}" 
													data-cost="{{ $purchase->cost_price }}"
													data-stock="{{ $purchase->quantity }}"
													data-expiry="{{ optional($purchase->expiry_date)->format('Y-m-d') }}">
												{{ $purchase->product }}
												<span class="stock-info">
													(Stock: {{ $purchase->quantity }} |
													Cost: ${{ number_format($purchase->cost_price, 2) }})
												</span>
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>

					<!-- Price Calculation Section -->
					<div class="price-calculator">
						<div class="calculator-title">
							<i class="fas fa-calculator"></i>
							Price Calculation
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Cost Price</label>
									<div class="input-group-icon">
										<input class="form-control" type="text" id="costPrice" readonly placeholder="$0.00">
										<i class="fas fa-dollar-sign input-icon"></i>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="form-group">
									<label>Margin (%) <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input class="form-control" type="number" name="margin" id="marginInput"
											   value="{{ old('margin', 20) }}" min="0" max="1000" step="0.1" required>
										<i class="fas fa-percentage input-icon"></i>
									</div>
									<small class="form-text text-muted">Percentage to add to cost price</small>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="form-group">
									<label>Selling Price <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input class="form-control" type="text" id="sellingPrice" 
											   name="price" readonly placeholder="$0.00">
										<i class="fas fa-tag input-icon"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="profit-indicator" id="profitIndicator">
							Expected Profit: $<span id="profitAmount">0.00</span>
						</div>
					</div>

					<!-- Additional Information Section -->
					<div class="service-fields">
						<h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
							<i class="fas fa-info-circle mr-2" style="color: #667eea;"></i>
							Stock & Product Details
						</h5>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Current Stock</label>
									<div class="input-group-icon">
										<input class="form-control" type="text" id="currentStock" readonly placeholder="0 units">
										<i class="fas fa-boxes input-icon"></i>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Minimum Stock Level <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input type="number" name="minimum_stock" class="form-control"
											   value="{{ old('minimum_stock', 5) }}" min="1" required>
										<i class="fas fa-exclamation-triangle input-icon"></i>
									</div>
									<small class="form-text text-muted">Alert when stock falls below this level</small>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Product Status</label>
									<div class="form-control" id="productStatus" style="border: 1px solid #e8ecef; background: #f8f9fa; color: #333;">
										Select a product to see status
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" name="description" rows="3" placeholder="Enter product description (optional)">{{ old('description') }}</textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn submit-btn" type="submit">
							<i class="fas fa-save mr-2"></i>
							Save Product
						</button>
						<a href="{{ route('products.index') }}" class="cancel-btn">
							<i class="fas fa-times mr-2"></i>
							Cancel
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page-js')
<script>
	$(document).ready(function() {
		// Initialize Select2 first
		$('.select2').select2({
			theme: 'default',
			width: '100%',
			placeholder: 'Choose a product...'
		});

		const productSelect = document.getElementById('productSelect');
		const marginInput = document.getElementById('marginInput');
		const costPriceInput = document.getElementById('costPrice');
		const sellingPriceInput = document.getElementById('sellingPrice');
		const currentStockInput = document.getElementById('currentStock');
		const productStatus = document.getElementById('productStatus');
		const profitAmount = document.getElementById('profitAmount');

		function calculatePrice() {
			const selectedOption = productSelect.options[productSelect.selectedIndex];
			
			if (!selectedOption || !selectedOption.value) {
				costPriceInput.value = '$0.00';
				sellingPriceInput.value = '$0.00';
				currentStockInput.value = '0 units';
				productStatus.innerHTML = 'Select a product to see status';
				productStatus.className = 'form-control';
				profitAmount.textContent = '0.00';
				return;
			}

			const costPrice = parseFloat(selectedOption.dataset.cost) || 0;
			const stock = parseInt(selectedOption.dataset.stock) || 0;
			const margin = parseFloat(marginInput.value) || 20;
			const sellingPrice = costPrice * (1 + (margin / 100));
			const profit = sellingPrice - costPrice;
			const expiryDate = selectedOption.dataset.expiry;
			const today = new Date().toISOString().split('T')[0];

			// Update price fields
			costPriceInput.value = '$' + costPrice.toFixed(2);
			sellingPriceInput.value = '$' + sellingPrice.toFixed(2);
			currentStockInput.value = stock + ' units';
			profitAmount.textContent = profit.toFixed(2);

			// Update profit indicator color
			const profitIndicator = document.getElementById('profitIndicator');
			if (profit > 0) {
				profitIndicator.style.background = 'rgba(40, 199, 111, 0.1)';
				profitIndicator.style.color = '#28c76f';
			} else {
				profitIndicator.style.background = 'rgba(234, 84, 85, 0.1)';
				profitIndicator.style.color = '#ea5455';
			}

			// Update product status
			let statusText = '';
			let statusClass = 'form-control';
			
			if (expiryDate && expiryDate < today) {
				statusText = '⚠️ EXPIRED - Cannot be sold';
				statusClass = 'form-control status-danger';
			} else if (stock <= 0) {
				statusText = '❌ OUT OF STOCK';
				statusClass = 'form-control status-danger';
			} else if (stock <= 5) {
				statusText = '⚠️ LOW STOCK - ' + stock + ' remaining';
				statusClass = 'form-control status-warning';
			} else {
				statusText = '✅ IN STOCK - ' + stock + ' available';
				statusClass = 'form-control status-success';
			}

			productStatus.innerHTML = statusText;
			productStatus.className = statusClass;

			// Validate margin
			if (margin < 0) {
				marginInput.value = 0;
			} else if (margin > 1000) {
				marginInput.value = 1000;
			}
		}

		// Event listeners
		productSelect.addEventListener('change', calculatePrice);
		marginInput.addEventListener('input', calculatePrice);

		// Select2 change event
		$('#productSelect').on('select2:select', function (e) {
			calculatePrice();
		});

		// Initialize after a short delay
		setTimeout(function() {
			calculatePrice();
		}, 300);

		// Form submission validation
		document.getElementById('productForm').addEventListener('submit', function(e) {
			const selectedOption = productSelect.options[productSelect.selectedIndex];
			
			if (!selectedOption || !selectedOption.value) {
				e.preventDefault();
				alert('Please select a product!');
				return false;
			}

			const stock = parseInt(selectedOption.dataset.stock) || 0;
			const expiryDate = selectedOption.dataset.expiry;
			const today = new Date().toISOString().split('T')[0];

			if (expiryDate && expiryDate < today) {
				e.preventDefault();
				alert('Warning: Selected product has expired!');
				return false;
			}

			if (stock <= 0) {
				e.preventDefault();
				alert('Warning: Selected product is out of stock!');
				return false;
			}

			// Show loading state
			const submitBtn = document.querySelector('.submit-btn');
			submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
			submitBtn.disabled = true;

			return true;
		});

		// Real-time validation
		const requiredFields = document.querySelectorAll('[required]');
		requiredFields.forEach(field => {
			field.addEventListener('blur', function() {
				if (this.value && this.value.trim() !== '') {
					this.classList.remove('is-invalid');
					this.classList.add('is-valid');
				} else {
					this.classList.remove('is-valid');
					this.classList.add('is-invalid');
				}
			});
		});
	});
</script>
@endpush