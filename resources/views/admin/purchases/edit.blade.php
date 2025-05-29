@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Edit Purchase</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{route('purchases.index')}}">Purchases</a></li>
		<li class="breadcrumb-item active">Edit Purchase</li>
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
					Edit Medicine Purchase
				</h4>
				<div class="card-header-info">
					<span class="badge badge-info">Editing: {{$purchase->product}}</span>
				</div>
			</div>
			<div class="card-body custom-edit-service">
			
			<!-- Edit Purchase -->
			<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('purchases.update',$purchase)}}">
				@csrf
				@method("PUT")
				
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
								<input class="form-control" type="text" value="{{$purchase->product}}" name="product" placeholder="Enter medicine name" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Category <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control" name="category" required> 
									@foreach ($categories as $category)
										<option {{($purchase->category->id == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Supplier <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control" name="supplier" required> 
									@foreach ($suppliers as $supplier)
										<option @if($purchase->supplier->id == $supplier->id) selected @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
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
								<input class="form-control" value="{{$purchase->cost_price}}" type="number" step="0.01" name="cost_price" placeholder="0.00" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Quantity <span class="text-danger">*</span></label>
								<input class="form-control" value="{{$purchase->quantity}}" type="number" name="quantity" placeholder="Enter quantity" required>
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
								<input class="form-control" value="{{$purchase->expiry_date}}" type="date" name="expiry_date" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Medicine Image</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<small class="form-text text-muted">Upload new image to replace current one</small>
								@if($purchase->image)
									<div class="current-image-preview mt-2">
										<img src="{{asset('storage/purchases/'.$purchase->image)}}" alt="Current Image" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
										<small class="d-block text-muted">Current Image</small>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				
				<div class="submit-section">
					<button class="btn btn-success submit-btn" type="submit">
						<i class="fas fa-save mr-2"></i>
						Update Purchase
					</button>
					<a href="{{route('purchases.index')}}" class="btn btn-secondary ml-2">
						<i class="fas fa-times mr-2"></i>
						Cancel
					</a>
				</div>
			</form>
			<!-- /Edit Purchase -->

			</div>
		</div>
	</div>			
</div>

<style>
/* Enhanced styling for edit form */
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
	display: flex;
	justify-content: space-between;
	align-items: center;
}

.card-header h4 {
	color: white !important;
	margin: 0;
	font-weight: 600;
}

.card-header-info .badge {
	background: rgba(255, 255, 255, 0.2) !important;
	color: white !important;
	font-size: 12px;
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
	box-shadow: 0 5px 15px rgba(255, 159, 67, 0.3);
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

.current-image-preview {
	padding: 10px;
	background: #f8f9fa;
	border-radius: 8px;
	text-align: center;
}

.current-image-preview img {
	border-radius: 8px;
}
</style>
@endsection	

@push('page-js')
	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
	
	<script>
		$(document).ready(function() {
			// Initialize Select2
			$('.select2').select2({
				theme: 'default',
				width: '100%'
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