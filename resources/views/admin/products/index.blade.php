@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
<style>
	/* Modern Products Index Styling */
	.card {
		border: none;
		border-radius: 15px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
		overflow: hidden;
	}

	.card-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		color: white !important;
		border-radius: 0 !important;
		padding: 20px 25px;
	}

	.card-title {
		color: white !important;
		margin: 0;
		font-weight: 600;
		font-size: 1.2rem;
	}

	.btn-success {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		border: none !important;
		color: white !important;
		border-radius: 8px !important;
		font-weight: 600 !important;
		transition: all 0.3s ease !important;
	}

	.btn-success:hover {
		color: white !important;
		transform: translateY(-2px) !important;
		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3) !important;
	}

	/* Statistics Overview */
	.stats-overview {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: 20px;
		margin-bottom: 30px;
	}

	.stat-card {
		background: white;
		border-radius: 12px;
		padding: 25px;
		box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
		border: 1px solid #f0f0f0;
		transition: all 0.3s ease;
		position: relative;
		overflow: hidden;
	}

	.stat-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 4px;
		height: 100%;
		background: var(--stat-color, #667eea);
	}

	.stat-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
	}

	.stat-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 15px;
	}

	.stat-icon {
		width: 50px;
		height: 50px;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
		background: var(--stat-bg, rgba(102, 126, 234, 0.1));
		color: var(--stat-color, #667eea);
	}

	.stat-value {
		font-size: 1.8rem;
		font-weight: 700;
		color: #333;
		margin-bottom: 5px;
	}

	.stat-label {
		color: #6c757d;
		font-size: 14px;
		font-weight: 500;
	}

	.stat-trend {
		font-size: 12px;
		padding: 2px 8px;
		border-radius: 12px;
		font-weight: 600;
	}

	.trend-up {
		background: rgba(40, 199, 111, 0.1);
		color: #28c76f;
	}

	.trend-down {
		background: rgba(234, 84, 85, 0.1);
		color: #ea5455;
	}

	.trend-stable {
		background: rgba(108, 117, 125, 0.1);
		color: #6c757d;
	}

	/* Data Table Styling */
	.datatable thead th {
		background: #f8f9fa;
		border: none;
		padding: 15px 12px;
		font-weight: 600;
		color: #333;
		text-transform: uppercase;
		font-size: 12px;
		letter-spacing: 0.5px;
	}

	.datatable tbody td {
		padding: 15px 12px;
		vertical-align: middle;
		border-top: 1px solid #f0f0f0;
	}

	.datatable tbody tr {
		transition: all 0.3s ease;
	}

	.datatable tbody tr:hover {
		background: #f8f9fa;
		transform: translateX(2px);
	}

	/* Action buttons */
	.action-btn {
		text-align: center;
	}

	.btn-sm {
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 500;
		transition: all 0.3s ease;
		margin: 0 2px;
	}

	/* DataTable pagination */
	.dataTables_wrapper .dataTables_paginate .paginate_button.current {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		border-color: #667eea !important;
		color: white !important;
		border-radius: 8px !important;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		background: #f8f9fa !important;
		border-color: #667eea !important;
		color: #667eea !important;
		border-radius: 8px !important;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button {
		border-radius: 8px !important;
		margin: 0 2px !important;
	}

	.dataTables_wrapper .dataTables_length select,
	.dataTables_wrapper .dataTables_filter input {
		border: 1px solid #e0e0e0;
		border-radius: 8px;
		padding: 6px 12px;
	}

	.dataTables_wrapper .dataTables_filter input:focus {
		border-color: #667eea;
		box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
	}

	/* Responsive */
	@media (max-width: 768px) {
		.stats-overview {
			grid-template-columns: 1fr;
		}
	}
</style>
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Products</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Products</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('products.create')}}" class="btn btn-success float-right mt-2">Add Product</a>
</div>
@endpush

@section('content')
<!-- Statistics Overview -->
<div class="stats-overview">
	<div class="stat-card" style="--stat-color: #667eea; --stat-bg: rgba(102, 126, 234, 0.1);">
		<div class="stat-header">
			<div class="stat-icon">
				<i class="fas fa-pills"></i>
			</div>
			<div class="stat-trend trend-up">+12%</div>
		</div>
		<div class="stat-value">{{DB::table('products')->whereNull('deleted_at')->count()}}</div>
		<div class="stat-label">Total Products</div>
	</div>
	
	<div class="stat-card" style="--stat-color: #28c76f; --stat-bg: rgba(40, 199, 111, 0.1);">
		<div class="stat-header">
			<div class="stat-icon">
				<i class="fas fa-check-circle"></i>
			</div>
			<div class="stat-trend trend-up">+5%</div>
		</div>
		<div class="stat-value">
			{{DB::table('products')
				->join('purchases', 'products.purchase_id', '=', 'purchases.id')
				->whereNull('products.deleted_at')
				->where('purchases.quantity', '>', 0)
				->count()}}
		</div>
		<div class="stat-label">In Stock</div>
	</div>
	
	<div class="stat-card" style="--stat-color: #ff9f43; --stat-bg: rgba(255, 159, 67, 0.1);">
		<div class="stat-header">
			<div class="stat-icon">
				<i class="fas fa-exclamation-triangle"></i>
			</div>
			<div class="stat-trend trend-down">-2%</div>
		</div>
		<div class="stat-value">
			{{DB::table('products')
				->join('purchases', 'products.purchase_id', '=', 'purchases.id')
				->whereNull('products.deleted_at')
				->where('purchases.quantity', '<=', 5)
				->where('purchases.quantity', '>', 0)
				->count()}}
		</div>
		<div class="stat-label">Low Stock</div>
	</div>
	
	<div class="stat-card" style="--stat-color: #ea5455; --stat-bg: rgba(234, 84, 85, 0.1);">
		<div class="stat-header">
			<div class="stat-icon">
				<i class="fas fa-times-circle"></i>
			</div>
			<div class="stat-trend trend-stable">0%</div>
		</div>
		<div class="stat-value">
			{{DB::table('products')
				->join('purchases', 'products.purchase_id', '=', 'purchases.id')
				->whereNull('products.deleted_at')
				->where('purchases.quantity', '<=', 0)
				->count()}}
		</div>
		<div class="stat-label">Out of Stock</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<!-- Products -->
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-list mr-2"></i>
					Product Management
				</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="product-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Product Name</th>
								<th>Category</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Margin</th>
								<th>Expiry Date</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
														
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Products -->
	</div>
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('products.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'margin', name: 'margin'},
				{data: 'expiry_date', name: 'expiry_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script> 
@endpush