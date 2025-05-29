@extends('admin.layouts.app')

@push('page-css')
<style>
	/* Modern Sales Edit Form Styling */
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

	.sale-summary {
		background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
		border: 2px solid rgba(102, 126, 234, 0.15);
		border-radius: 15px;
		padding: 25px;
		margin-bottom: 25px;
		position: relative;
		overflow: hidden;
	}

	.sale-summary::before {
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

	.summary-title {
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

	.submit-section {
		margin-top: 30px;
		padding-top: 20px;
		border-top: 1px solid #f0f0f0;
		display: flex;
		gap: 15px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.btn-success {
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

	.btn-success::before,
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

	.btn-success:hover::before,
	.cancel-btn:hover::before {
		left: 100%;
	}

	.btn-success:hover {
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

	/* Sale Info Display */
	.sale-info-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 20px;
		margin-bottom: 20px;
	}

	.info-item {
		background: white;
		padding: 15px;
		border-radius: 8px;
		border: 1px solid #f0f0f0;
		text-align: center;
	}

	.info-label {
		font-size: 12px;
		color: #6c757d;
		font-weight: 500;
		margin-bottom: 5px;
	}

	.info-value {
		font-size: 16px;
		font-weight: 600;
		color: #333;
	}

	.price-value {
		color: #28c76f;
	}

	.quantity-value {
		color: #667eea;
	}

	.date-value {
		color: #ff9f43;
	}

	/* Calculation Display */
	.calculation-display {
		background: rgba(40, 199, 111, 0.1);
		border: 1px solid rgba(40, 199, 111, 0.2);
		border-radius: 10px;
		padding: 15px;
		margin-top: 15px;
	}

	.calc-row {
		display: flex;
		justify-content: space-between;
		margin-bottom: 10px;
		font-size: 14px;
	}

	.calc-row:last-child {
		margin-bottom: 0;
		font-weight: 700;
		font-size: 16px;
		padding-top: 10px;
		border-top: 1px solid rgba(40, 199, 111, 0.3);
		color: #28c76f;
	}

	/* Page Header Styling */
	.page-title {
		color: #333;
		font-weight: 700;
		margin: 0;
	}

	.breadcrumb {
		background: transparent;
		margin: 0;
		padding: 0;
	}

	.breadcrumb-item a {
		color: #667eea;
		text-decoration: none;
	}

	.breadcrumb-item.active {
		color: #6c757d;
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

		.btn-success,
		.cancel-btn {
			width: 100%;
			max-width: 300px;
		}

		.sale-info-grid {
			grid-template-columns: 1fr;
		}
	}
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Edit Sale</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{route('sales.index')}}">Sales</a></li>
		<li class="breadcrumb-item active">Edit Sale</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-edit mr-2"></i>
					Edit Sale Record
				</h4>
			</div>
			<div class="card-body custom-edit-service">
				<div class="info-badge">
					<i class="fas fa-info-circle mr-2"></i>
					Editing sale record from: <strong>{{date_format(date_create($sale->created_at),'d M, Y')}}</strong>
				</div>

				<!-- Current Sale Summary -->
				<div class="sale-summary">
					<div class="summary-title">
						<i class="fas fa-receipt"></i>
						Current Sale Information
					</div>
					<div class="sale-info-grid">
						<div class="info-item">
							<div class="info-label">Current Product</div>
							<div class="info-value">{{$sale->product->purchase->product ?? 'Unknown Product'}}</div>
						</div>
						<div class="info-item">
							<div class="info-label">Current Quantity</div>
							<div class="info-value quantity-value">{{$sale->quantity}} units</div>
						</div>
						<div class="info-item">
							<div class="info-label">Current Total</div>
							<div class="info-value price-value">${{number_format($sale->total_price, 2)}}</div>
						</div>
						<div class="info-item">
							<div class="info-label">Sale Date</div>
							<div class="info-value date-value">{{date_format(date_create($sale->created_at),'d M, Y')}}</div>
						</div>
					</div>
				</div>

				<!-- Edit Sale Form -->
				<form method="POST" action="{{route('sales.update',$sale)}}" id="editSaleForm">
					@csrf
					@method("PUT")
					
					<!-- Product Selection Section -->
					<div class="service-fields">
						<h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
							<i class="fas fa-pills mr-2" style="color: #667eea;"></i>
							Update Product Information
						</h5>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Product <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control edit_product" name="product" id="productSelect"> 
										@foreach ($products as $product)
											@if (!empty($product->purchase))
												@if (!($product->purchase->quantity <= 0))
													<option {{($product->purchase->id == $sale->product->purchase_id) ? 'selected': ''}} 
															value="{{$product->id}}"
															data-price="{{$product->price}}"
															data-stock="{{$product->purchase->quantity}}">
														{{$product->purchase->product}} (Stock: {{$product->purchase->quantity}} | Price: ${{number_format($product->price, 2)}})
													</option>
												@endif
											@endif
										@endforeach
									</select>
									@error('product')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</div>

					<!-- Quantity and Calculation Section -->
					<div class="service-fields">
						<h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
							<i class="fas fa-calculator mr-2" style="color: #667eea;"></i>
							Quantity & Price Calculation
						</h5>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Quantity <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input type="number" class="form-control edit_quantity" 
											   value="{{$sale->quantity ?? '1'}}" 
											   name="quantity" 
											   id="quantityInput"
											   min="1" 
											   required>
										<i class="fas fa-sort-numeric-up input-icon"></i>
									</div>
									<small class="form-text text-muted">Enter the quantity of items sold</small>
									@error('quantity')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Unit Price</label>
									<div class="input-group-icon">
										<input type="text" class="form-control" id="unitPrice" readonly placeholder="$0.00">
										<i class="fas fa-dollar-sign input-icon"></i>
									</div>
									<small class="form-text text-muted">Price per unit (automatically calculated)</small>
								</div>
							</div>
						</div>

						<!-- Live Calculation Display -->
						<div class="calculation-display" id="calculationDisplay">
							<div class="calc-row">
								<span>Unit Price:</span>
								<span id="displayUnitPrice">${{number_format($sale->product->price ?? 0, 2)}}</span>
							</div>
							<div class="calc-row">
								<span>Quantity:</span>
								<span id="displayQuantity">{{$sale->quantity}} units</span>
							</div>
							<div class="calc-row">
								<span>Total Amount:</span>
								<span id="displayTotal">${{number_format($sale->total_price, 2)}}</span>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn btn-success" type="submit">
							<i class="fas fa-save mr-2"></i>
							Save Changes
						</button>
						<a href="{{route('sales.index')}}" class="cancel-btn">
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
	// Initialize Select2
	$('.select2').select2({
		theme: 'default',
		width: '100%'
	});

	const productSelect = document.getElementById('productSelect');
	const quantityInput = document.getElementById('quantityInput');
	const unitPriceInput = document.getElementById('unitPrice');

	function updateCalculation() {
		const selectedOption = productSelect.options[productSelect.selectedIndex];
		const quantity = parseInt(quantityInput.value) || 1;
		
		if (selectedOption && selectedOption.value) {
			const price = parseFloat(selectedOption.dataset.price) || 0;
			const stock = parseInt(selectedOption.dataset.stock) || 0;
			const total = price * quantity;

			// Update unit price display
			unitPriceInput.value = '$' + price.toFixed(2);

			// Update calculation display
			document.getElementById('displayUnitPrice').textContent = '$' + price.toFixed(2);
			document.getElementById('displayQuantity').textContent = quantity + ' units';
			document.getElementById('displayTotal').textContent = '$' + total.toFixed(2);

			// Validate stock
			if (quantity > stock) {
				quantityInput.style.borderColor = '#ea5455';
				quantityInput.style.background = 'rgba(234, 84, 85, 0.1)';
				alert('Warning: Quantity exceeds available stock (' + stock + ' units)');
			} else {
				quantityInput.style.borderColor = '#28c76f';
				quantityInput.style.background = 'rgba(40, 199, 111, 0.1)';
			}
		} else {
			// Reset displays
			unitPriceInput.value = '$0.00';
			document.getElementById('displayUnitPrice').textContent = '$0.00';
			document.getElementById('displayQuantity').textContent = '0 units';
			document.getElementById('displayTotal').textContent = '$0.00';
		}
	}

	// Event listeners
	productSelect.addEventListener('change', updateCalculation);
	quantityInput.addEventListener('input', updateCalculation);

	// Select2 change event
	$('#productSelect').on('select2:select', function (e) {
		updateCalculation();
	});

	// Initial calculation
	updateCalculation();

	// Form validation
	document.getElementById('editSaleForm').addEventListener('submit', function(e) {
		const quantity = parseInt(quantityInput.value);
		const selectedOption = productSelect.options[productSelect.selectedIndex];
		
		if (!selectedOption || !selectedOption.value) {
			e.preventDefault();
			alert('Please select a product!');
			return false;
		}

		if (quantity <= 0) {
			e.preventDefault();
			alert('Quantity must be greater than 0!');
			quantityInput.focus();
			return false;
		}

		const stock = parseInt(selectedOption.dataset.stock) || 0;
		if (quantity > stock) {
			if (!confirm('Quantity exceeds available stock (' + stock + ' units). Continue anyway?')) {
				e.preventDefault();
				return false;
			}
		}

		// Show loading state
		const submitBtn = document.querySelector('.btn-success');
		submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
		submitBtn.disabled = true;

		return true;
	});

	// Real-time validation
	quantityInput.addEventListener('blur', function() {
		if (this.value && parseInt(this.value) > 0) {
			this.classList.remove('is-invalid');
			this.classList.add('is-valid');
		} else {
			this.classList.remove('is-valid');
			this.classList.add('is-invalid');
		}
	});
});
</script>
@endpush