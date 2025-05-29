@extends('admin.layouts.app')

@push('page-css')
<style>
	/* Modern Product Edit Form Styling - Wide Layout */
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
	<h3 class="page-title">Edit Product</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>
		<li class="breadcrumb-item active">Edit Product</li>
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
					Edit Product
				</h4>
			</div>
			<div class="card-body custom-edit-service">
				<div class="info-badge">
					<i class="fas fa-info-circle mr-2"></i>
					Editing product: <strong>{{$product->purchase->product ?? 'Unknown Product'}}</strong>
				</div>

				<!-- Edit Product -->
				<form method="post" enctype="multipart/form-data" action="{{route('products.update',$product)}}" id="editProductForm">
					@csrf
					@method("PUT")
					
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
										@foreach ($purchases as $purchase)
											<option value="{{$purchase->id}}"
												@if($product->purchase && $product->purchase->id == $purchase->id) selected @endif
												data-cost="{{ $purchase->cost_price }}"
											>
												{{ $purchase->product }} 
												@if($purchase->quantity <= 0)
													(Out of Stock)
												@else
													(Stock: {{$purchase->quantity}})
												@endif
											</option>
										@endforeach
									</select>
									@error('product')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
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
										<input class="form-control" type="text" id="costPrice" 
											   value="{{ number_format($product->purchase->cost_price ?? 0, 2) }}" readonly>
										<i class="fas fa-dollar-sign input-icon"></i>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<div class="form-group">
									<label>Margin (%) <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input class="form-control" type="number" name="margin" id="marginInput" 
											   value="{{ old('margin', $product->margin) }}" 
											   min="0" max="1000" step="0.1" required>
										<i class="fas fa-percentage input-icon"></i>
									</div>
									<small class="form-text text-muted">Percentage to add to cost price</small>
									@error('margin')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
								</div>
							</div>
							
							<div class="col-lg-4">
								<div class="form-group">
									<label>Selling Price <span class="text-danger">*</span></label>
									<div class="input-group-icon">
										<input class="form-control" type="text" name="price" id="sellingPrice" 
											   value="{{ old('price', number_format($product->price, 2)) }}" readonly>
										<i class="fas fa-tag input-icon"></i>
									</div>
									@error('price')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="profit-indicator" id="profitIndicator">
							Current Profit: $<span id="profitAmount">{{number_format(($product->price - ($product->purchase->cost_price ?? 0)), 2)}}</span>
						</div>
					</div>

					<!-- Additional Information Section -->
					<div class="service-fields">
						<h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
							<i class="fas fa-info-circle mr-2" style="color: #667eea;"></i>
							Additional Information
						</h5>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Minimum Stock Level</label>
									<div class="input-group-icon">
										<input type="number" name="minimum_stock" class="form-control" 
											   value="{{ old('minimum_stock', $product->minimum_stock ?? 5) }}" min="1">
										<i class="fas fa-exclamation-triangle input-icon"></i>
									</div>
									<small class="form-text text-muted">Alert when stock falls below this level</small>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Current Status</label>
									<div class="form-control" style="border: 1px solid #e8ecef; background: #f8f9fa; color: #333;">
										@if($product->purchase && $product->purchase->quantity > 0)
											✅ In Stock ({{$product->purchase->quantity}} available)
										@else
											❌ Out of Stock
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control service-desc" name="description" 
											  rows="4" placeholder="Enter product description (optional)">{{ old('description', $product->description) }}</textarea>
									@error('description')
										<div class="text-danger mt-2">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn submit-btn" type="submit">
							<i class="fas fa-save mr-2"></i>
							Update Product
						</button>
						<a href="{{route('products.index')}}" class="cancel-btn">
							<i class="fas fa-times mr-2"></i>
							Cancel
						</a>
					</div>
				</form>
				<!-- /Edit Product -->
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

	const productSelect = document.querySelector('select[name="product"]');
	const costPriceInput = document.getElementById('costPrice');
	const marginInput = document.getElementById('marginInput');
	const sellingPriceInput = document.getElementById('sellingPrice');
	const profitAmount = document.getElementById('profitAmount');

	function calculateSellingPrice() {
		const costPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.cost) || 0;
		const margin = parseFloat(marginInput.value) || 0;
		const sellingPrice = costPrice * (1 + (margin / 100));
		const profit = sellingPrice - costPrice;
		
		sellingPriceInput.value = sellingPrice.toFixed(2);
		if (profitAmount) {
			profitAmount.textContent = profit.toFixed(2);
		}

		// Update profit indicator color
		const profitIndicator = document.getElementById('profitIndicator');
		if (profit > 0) {
			profitIndicator.style.background = 'rgba(40, 199, 111, 0.1)';
			profitIndicator.style.color = '#28c76f';
		} else {
			profitIndicator.style.background = 'rgba(234, 84, 85, 0.1)';
			profitIndicator.style.color = '#ea5455';
		}
	}

	// Initial calculation
	calculateSellingPrice();

	// Event listeners
	productSelect.addEventListener('change', function() {
		const selectedOption = this.options[this.selectedIndex];
		costPriceInput.value = parseFloat(selectedOption.dataset.cost).toFixed(2);
		calculateSellingPrice();
	});

	marginInput.addEventListener('input', calculateSellingPrice);

	// Form validation
	document.getElementById('editProductForm').addEventListener('submit', function(e) {
		const margin = parseFloat(marginInput.value);
		if (margin < 0 || margin > 1000) {
			e.preventDefault();
			alert('Margin must be between 0% and 1000%');
			marginInput.focus();
			return false;
		}

		// Show loading state
		const submitBtn = document.querySelector('.submit-btn');
		submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
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