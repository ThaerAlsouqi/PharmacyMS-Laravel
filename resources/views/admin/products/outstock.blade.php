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
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Outstock</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>
		<li class="breadcrumb-item active">Outstock</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- Outstock Products -->
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-box-open mr-2"></i>
					Out of Stock Products
				</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="outstock-product" class="table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Brand Name</th>
								<th>Category</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Margin</th>
								<th>Expire</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Outstock Products-->
		
	</div>
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        $('#outstock-product').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('outstock')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'margin', name: 'margin', defaultContent: 'N/A'},
                {data: 'expiry_date', name: 'expiry_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script> 
@endpush