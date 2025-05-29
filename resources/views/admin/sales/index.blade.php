@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
<style>
	.card {
		border: none;
		border-radius: 15px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
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

	.card-body {
		padding: 25px;
	}

	.table thead th {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		font-weight: 600;
		border: none;
		padding: 15px 12px;
	}

	.table tbody tr:hover {
		background: rgba(102, 126, 234, 0.05);
	}

	/* Fix DataTable search */
	.dataTables_wrapper .dataTables_filter input {
		border: 1px solid #ccc !important;
		border-radius: 4px !important;
		padding: 6px 12px !important;
		margin-left: 8px !important;
		background: white !important;
	}

	.dataTables_wrapper .dataTables_filter input:focus {
		border-color: #667eea !important;
		outline: none !important;
		box-shadow: 0 0 5px rgba(102, 126, 234, 0.3) !important;
	}

	.dataTables_wrapper .dataTables_length select {
		border: 1px solid #ccc !important;
		border-radius: 4px !important;
		padding: 4px 8px !important;
		margin: 0 8px !important;
	}

	/* Remove any conflicting search styles */
	.dataTables_filter input[type="search"] {
		-webkit-appearance: textfield !important;
	}

	.dataTables_filter input[type="search"]::-webkit-search-cancel-button {
		-webkit-appearance: searchfield-cancel-button !important;
	}

	/* Add Sale Button Styling */
	.btn-success {
		background: linear-gradient(135deg, #28c76f 0%, #48da89 100%) !important;
		border: none !important;
		border-radius: 8px !important;
		padding: 10px 20px !important;
		font-weight: 600 !important;
		transition: all 0.3s ease !important;
	}

	.btn-success:hover {
		transform: translateY(-2px) !important;
		box-shadow: 0 5px 15px rgba(40, 199, 111, 0.3) !important;
		color: white !important;
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
</style>
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Sales</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Sales</li>
	</ul>
</div>
@can('create-sale')
<div class="col-sm-5 col">
	<a href="{{route('sales.create')}}" class="btn btn-success float-right mt-2">
		<i class="fas fa-plus mr-2"></i>Add Sale
	</a>
</div>
@endcan
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- Sales -->
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-shopping-cart mr-2"></i>
					Sales Records
				</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="sales-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Medicine Name</th>
								<th>Quantity</th>
								<th>Total Price</th>
								<th>Date</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Sales -->
		
	</div>
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('sales.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'quantity', name: 'quantity'},
                {data: 'total_price', name: 'total_price'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script> 
@endpush