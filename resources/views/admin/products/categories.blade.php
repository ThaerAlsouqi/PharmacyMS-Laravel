@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
<style>
	/* Modern Categories styling */
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

	.btn-primary {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
		border: none !important;
		color: white !important;
		border-radius: 8px !important;
		font-weight: 600 !important;
		transition: all 0.3s ease !important;
	}

	.btn-primary:hover {
		color: white !important;
		transform: translateY(-2px) !important;
		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3) !important;
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
		transform: translateX(2px);
	}

	/* Action buttons */
	.btn-sm {
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 500;
		transition: all 0.3s ease;
		margin: 0 2px;
	}

	.btn-edit {
		background: #ff9f43;
		border-color: #ff9f43;
		color: white;
	}

	.btn-edit:hover {
		background: #ff8c2e;
		color: white;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(255, 159, 67, 0.3);
	}

	.btn-delete {
		background: #ea5455;
		border-color: #ea5455;
		color: white;
	}

	.btn-delete:hover {
		background: #e63e3f;
		color: white;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(234, 84, 85, 0.3);
	}

	/* Modal Improvements */
	.modal-content {
		border: none;
		border-radius: 15px;
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
		overflow: hidden;
	}

	.modal-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		border-bottom: none;
		padding: 20px 30px;
	}

	.modal-header h5 {
		color: white;
		font-weight: 600;
		margin: 0;
	}

	.modal-header .close {
		color: white;
		opacity: 0.8;
		font-size: 1.5rem;
	}

	.modal-header .close:hover {
		opacity: 1;
		color: white;
	}

	.modal-body {
		padding: 30px;
	}

	.form-group label {
		font-weight: 600;
		color: #333;
		margin-bottom: 8px;
	}

	.form-control {
		border: 2px solid #e8ecef;
		border-radius: 8px;
		padding: 12px 15px;
		transition: all 0.3s ease;
	}

	.form-control:focus {
		border-color: #667eea;
		box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
	}

	.btn-block {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border: none;
		border-radius: 8px;
		padding: 12px;
		font-weight: 600;
		transition: all 0.3s ease;
	}

	.btn-block:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
	}

	/* Stats Overview */
	.stats-overview {
		display: flex;
		gap: 20px;
		margin-bottom: 30px;
		flex-wrap: wrap;
	}

	.stat-card {
		background: white;
		border-radius: 12px;
		padding: 25px;
		box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
		border: 1px solid #f0f0f0;
		transition: all 0.3s ease;
		flex: 1;
		min-width: 200px;
	}

	.stat-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
	}

	.stat-icon {
		width: 60px;
		height: 60px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		margin-bottom: 15px;
		background: rgba(102, 126, 234, 0.1);
		color: #667eea;
	}

	.stat-value {
		font-size: 2rem;
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
	<h3 class="page-title">Categories</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Categories</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="#add_categories" data-toggle="modal" class="btn btn-primary float-right mt-2">
		<i class="fas fa-plus mr-2"></i>
		Add Category
	</a>
</div>
@endpush

@section('content')
<!-- Statistics Overview -->
<div class="stats-overview">
	<div class="stat-card">
		<div class="stat-icon">
			<i class="fas fa-th-large"></i>
		</div>
		<div class="stat-value">{{DB::table('categories')->count()}}</div>
		<div class="stat-label">Total Categories</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon" style="background: rgba(40, 199, 111, 0.1); color: #28c76f;">
			<i class="fas fa-pills"></i>
		</div>
		<div class="stat-value">{{DB::table('products')->whereNull('deleted_at')->count()}}</div>
		<div class="stat-label">Total Products</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon" style="background: rgba(255, 159, 67, 0.1); color: #ff9f43;">
			<i class="fas fa-chart-line"></i>
		</div>
		<div class="stat-value">
			@php
				$totalCategories = DB::table('categories')->count();
				$totalProducts = DB::table('products')->whereNull('deleted_at')->count();
				$average = $totalCategories > 0 ? round($totalProducts / $totalCategories, 1) : 0;
			@endphp
			{{$average}}
		</div>
		<div class="stat-label">Avg Products/Category</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					<i class="fas fa-list mr-2"></i>
					Category Management
				</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="category-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Category Name</th>
								<th>Created Date</th>
								<th class="text-center action-btn">Actions</th>
							</tr>
						</thead>
						<tbody>
												
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>			
</div>

<!-- Add Modal -->
<div class="modal fade" id="add_categories" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<i class="fas fa-plus mr-2"></i>
					Add New Category
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('categories.store')}}">
					@csrf
					<div class="form-group">
						<label>Category Name <span class="text-danger">*</span></label>
						<input type="text" name="name" class="form-control" placeholder="Enter category name" required>
						<small class="form-text text-muted">Enter a unique category name for your products</small>
					</div>
					<button type="submit" class="btn btn-success btn-block">
						<i class="fas fa-save mr-2"></i>
						Create Category
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /ADD Modal -->

<!-- Edit Details Modal -->
<div class="modal fade" id="edit_category" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: linear-gradient(135deg, #ff9f43 0%, #ff6b6b 100%);">
				<h5 class="modal-title">
					<i class="fas fa-edit mr-2"></i>
					Edit Category
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('categories.update')}}">
					@csrf
					@method("PUT")
					<input type="hidden" name="id" id="edit_id">
					<div class="form-group">
						<label>Category Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control edit_name" name="name" placeholder="Enter category name" required>
						<small class="form-text text-muted">Update the category name</small>
					</div>
					<button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #ff9f43 0%, #ff6b6b 100%); color: white;">
						<i class="fas fa-save mr-2"></i>
						Update Category
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Details Modal --> 
@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('categories.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            pageLength: 25,
            order: [[2, 'desc']], // Order by created_at desc
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories...",
                lengthMenu: "Show _MENU_ categories",
                info: "Showing _START_ to _END_ of _TOTAL_ categories",
                infoEmpty: "No categories found",
                infoFiltered: "(filtered from _MAX_ total categories)",
                zeroRecords: "No matching categories found",
                emptyTable: "No category data available"
            },
            responsive: true,
            autoWidth: false
        });

        // Edit category modal
        $('#category-table').on('click', '.editbtn', function() {
            $('#edit_category').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#edit_id').val(id);
            $('.edit_name').val(name);
        });

        // Form validation
        $('form').on('submit', function(e) {
            const nameInput = $(this).find('input[name="name"]');
            if (!nameInput.val().trim()) {
                e.preventDefault();
                alert('Please enter a category name.');
                nameInput.focus();
                return false;
            }
        });

        // Real-time validation
        $('input[name="name"]').on('input', function() {
            if ($(this).val().trim()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });

        // Custom search styling
        $('.dataTables_filter input').addClass('form-control').css({
            'width': '250px',
            'margin-left': '10px'
        });

        $('.dataTables_length select').addClass('form-control').css({
            'width': 'auto',
            'display': 'inline-block'
        });
    });
</script> 
@endpush