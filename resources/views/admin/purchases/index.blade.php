@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    <style>
		/* Modern DataTable styling */
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

		.page-header-actions {
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.btn-add-new {
			background: rgba(255, 255, 255, 0.2);
			border: 1px solid rgba(255, 255, 255, 0.3);
			color: white;
			border-radius: 10px;
			padding: 10px 20px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.btn-add-new:hover {
			background: white;
			color: #667eea;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
		}

		.table-responsive {
			border-radius: 0 0 15px 15px;
			overflow: hidden;
		}

		.datatable {
			margin-bottom: 0 !important;
		}

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
			transform: translateX(5px);
		}

		/* Action buttons */
		.action-btn {
			display: flex;
			gap: 8px;
			justify-content: center;
		}

		.btn-sm {
			padding: 6px 12px;
			border-radius: 6px;
			font-size: 12px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.btn-edit {
			background: #ff9f43;
			border-color: #ff9f43;
			color: white;
		}

		.btn-edit:hover {
			background: #ff8c2e;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(255, 159, 67, 0.3);
		}

		.btn-delete {
			background: #ea5455;
			border-color: #ea5455;
			color: white;
		}

		.btn-delete:hover {
			background: #e63e3f;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(234, 84, 85, 0.3);
		}

		.btn-view {
			background: #00cfe8;
			border-color: #00cfe8;
			color: white;
		}

		.btn-view:hover {
			background: #00b8d4;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(0, 207, 232, 0.3);
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

		/* Status badges */
		.badge {
			padding: 6px 12px;
			border-radius: 20px;
			font-weight: 500;
			font-size: 11px;
		}

		.badge-success {
			background: rgba(40, 199, 111, 0.1);
			color: #28c76f;
		}

		.badge-danger {
			background: rgba(234, 84, 85, 0.1);
			color: #ea5455;
		}

		.badge-warning {
			background: rgba(255, 159, 67, 0.1);
			color: #ff9f43;
		}

		/* Statistics cards */
		.stats-overview {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			margin-bottom: 30px;
		}

		.stat-card {
			background: white;
			border-radius: 12px;
			padding: 20px;
			box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
			border: 1px solid #f0f0f0;
			transition: all 0.3s ease;
		}

		.stat-card:hover {
			transform: translateY(-3px);
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
		}

		.stat-icon {
			width: 50px;
			height: 50px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 20px;
			margin-bottom: 15px;
		}

		.stat-icon.success {
			background: rgba(40, 199, 111, 0.1);
			color: #28c76f;
		}

		.stat-icon.info {
			background: rgba(0, 207, 232, 0.1);
			color: #00cfe8;
		}

		.stat-icon.warning {
			background: rgba(255, 159, 67, 0.1);
			color: #ff9f43;
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
	</style>
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Purchases</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Purchases</li>
	</ul>
</div>

@endpush

@section('content')
<!-- Statistics Overview -->
<div class="stats-overview">
	<div class="stat-card">
		<div class="stat-icon success">
			<i class="fas fa-shopping-cart"></i>
		</div>
		<div class="stat-value">{{DB::table('purchases')->count()}}</div>
		<div class="stat-label">Total Purchases</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon info">
			<i class="fas fa-boxes"></i>
		</div>
		<div class="stat-value">{{DB::table('purchases')->sum('quantity')}}</div>
		<div class="stat-label">Total Quantity</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon warning">
			<i class="fas fa-dollar-sign"></i>
		</div>
		<div class="stat-value">{{AppSettings::get('app_currency')}}{{number_format(DB::table('purchases')->sum('cost_price'), 2)}}</div>
		<div class="stat-label">Total Investment</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
	
		<!-- Purchases Table -->
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="card-title mb-0">
					<i class="fas fa-list mr-2"></i>
					Purchase Records
				</h4>
				<a href="{{route('purchases.create')}}" class="btn btn-light btn-sm">
					<i class="fas fa-plus mr-2"></i>
					Add New Purchase
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="purchase-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Medicine Name</th>
								<th>Category</th>
								<th>Supplier</th>
								<th>Purchase Cost</th>
								<th>Quantity</th>
								<th>Expire Date</th>
								<th class="action-btn">Actions</th>
							</tr>
						</thead>
						<tbody>
														
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Purchases Table -->
		
	</div>
</div>
@endsection	

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#purchase-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('purchases.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'supplier', name: 'supplier'},
                {data: 'cost_price', name: 'cost_price'},
                {data: 'quantity', name: 'quantity'},
				{data: 'expiry_date', name: 'expiry_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            pageLength: 25,
            order: [[0, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search purchases...",
                lengthMenu: "Show _MENU_ purchases",
                info: "Showing _START_ to _END_ of _TOTAL_ purchases",
                infoEmpty: "No purchases found",
                infoFiltered: "(filtered from _MAX_ total purchases)",
                zeroRecords: "No matching purchases found",
                emptyTable: "No purchase data available"
            },
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            responsive: true,
            autoWidth: false,
            columnDefs: [
                {
                    targets: -1,
                    className: 'text-center',
                    width: '120px'
                },
                {
                    targets: [3], // Cost price column
                    className: 'text-right'
                },
                {
                    targets: [4], // Quantity column
                    className: 'text-center'
                }
            ]
        });

        // Custom search styling
        $('.dataTables_filter input').addClass('form-control').css({
            'width': '300px',
            'margin-left': '10px'
        });

        // Custom length menu styling
        $('.dataTables_length select').addClass('form-control').css({
            'width': 'auto',
            'display': 'inline-block'
        });

        // Add loading animation
        table.on('processing.dt', function(e, settings, processing) {
            if (processing) {
                $('.card-body').addClass('loading');
            } else {
                $('.card-body').removeClass('loading');
            }
        });

        // Animate rows on load
        table.on('draw', function() {
            $('.datatable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });
        });
    });
</script> 
@endpush