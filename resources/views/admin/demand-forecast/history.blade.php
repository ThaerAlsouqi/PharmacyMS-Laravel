@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
<style>
    .history-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .history-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .prediction-row {
        transition: all 0.3s ease;
    }

    .prediction-row:hover {
        background: #f8f9fa !important;
        transform: scale(1.01);
    }

    .confidence-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    .confidence-high {
        background: rgba(40, 199, 111, 0.1);
        color: #28c76f;
        border: 1px solid rgba(40, 199, 111, 0.3);
    }

    .confidence-medium {
        background: rgba(255, 159, 67, 0.1);
        color: #ff9f43;
        border: 1px solid rgba(255, 159, 67, 0.3);
    }

    .confidence-low {
        background: rgba(234, 84, 85, 0.1);
        color: #ea5455;
        border: 1px solid rgba(234, 84, 85, 0.3);
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 2px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        background: rgba(0, 207, 232, 0.1);
        color: #00cfe8;
    }

    .btn-view:hover {
        background: #00cfe8;
        color: white;
    }

    .btn-delete {
        background: rgba(234, 84, 85, 0.1);
        color: #ea5455;
    }

    .btn-delete:hover {
        background: #ea5455;
        color: white;
    }

    .stats-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 15px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .filter-input {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
    }

    .filter-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    @media (max-width: 768px) {
        .history-header {
            padding: 1.5rem;
        }
        
        .filter-section {
            padding: 1rem;
        }
        
        .stats-number {
            font-size: 1.5rem;
        }
        
        .action-btn {
            width: 30px;
            height: 30px;
        }
    }
</style>
@endpush

@push('page-header')
<!-- History Header -->
<div class="history-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">
                <i class="fas fa-history"></i>
                Prediction History
            </h2>
            <p class="mb-0 opacity-75">View and manage all AI demand predictions made by your team</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('demand-forecast.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back to Forecasting
            </a>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <h3 class="page-title">Prediction History</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('demand-forecast.index') }}">AI Forecasting</a></li>
        <li class="breadcrumb-item active">History</li>
    </ul>
</div>
@endpush

@section('content')

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ $predictions->total() }}</div>
            <div class="stats-label">Total Predictions</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ $predictions->where('confidence', 'high')->count() }}</div>
            <div class="stats-label">High Confidence</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ $predictions->where('created_at', '>=', now()->subDays(7))->count() }}</div>
            <div class="stats-label">This Week</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ $predictions->where('created_at', '>=', now()->subDay())->count() }}</div>
            <div class="stats-label">Today</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filter-section">
    <div class="row align-items-center">
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label for="filter-drug" class="form-label">Filter by Medicine</label>
                <input type="text" id="filter-drug" class="form-control filter-input" placeholder="Search medicine...">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label for="filter-confidence" class="form-label">Confidence Level</label>
                <select id="filter-confidence" class="form-control filter-input">
                    <option value="">All Levels</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label for="filter-date" class="form-label">Date Range</label>
                <select id="filter-date" class="form-control filter-input">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group mb-0">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-primary w-100" onclick="clearFilters()">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Predictions Table -->
<div class="card history-card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i class="fas fa-table text-primary"></i>
            All Predictions ({{ $predictions->total() }} total)
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="predictions-table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Input Sales</th>
                        <th>Predicted Demand</th>
                        <th>Suggested Order</th>
                        <th>Confidence</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictions as $prediction)
                        <tr class="prediction-row" data-drug="{{ strtolower($prediction->drug_name) }}" 
                            data-confidence="{{ $prediction->confidence }}" 
                            data-date="{{ $prediction->created_at->format('Y-m-d') }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="medicine-icon me-3">
                                        <i class="fas fa-pills text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $prediction->drug_name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="input-sales">
                                    @if(is_array($prediction->recent_sales) && count($prediction->recent_sales) > 0)
                                        <small class="text-muted">
                                            @foreach($prediction->recent_sales as $index => $sale)
                                                {{ number_format($sale, 1) }}{{ $loop->last ? '' : ', ' }}
                                            @endforeach
                                        </small>
                                    @else
                                        <small class="text-muted">N/A</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info px-3 py-2">
                                    {{ number_format($prediction->predicted_demand, 1) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success px-3 py-2">
                                    {{ number_format($prediction->suggested_order, 1) }}
                                </span>
                            </td>
                            <td>
                                <span class="confidence-badge confidence-{{ $prediction->confidence }}">
                                    {{ ucfirst($prediction->confidence) }}
                                </span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <small class="text-muted">{{ $prediction->user->name }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div>{{ $prediction->created_at->format('M j, Y') }}</div>
                                    <small class="text-muted">{{ $prediction->created_at->format('g:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="action-btn btn-view" onclick="viewPrediction({{ $prediction->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="action-btn btn-delete" onclick="deletePrediction({{ $prediction->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Predictions Found</h5>
                                    <p class="text-muted">Start making predictions to see the history here.</p>
                                    <a href="{{ route('demand-forecast.index') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Make First Prediction
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($predictions->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $predictions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Prediction Details Modal -->
<div class="modal fade" id="predictionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line text-primary"></i>
                    Prediction Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-content">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-js')
<script>
$(document).ready(function() {
    // Filter functionality
    $('#filter-drug').on('input', function() {
        filterTable();
    });
    
    $('#filter-confidence, #filter-date').on('change', function() {
        filterTable();
    });
});

function filterTable() {
    const drugFilter = $('#filter-drug').val().toLowerCase();
    const confidenceFilter = $('#filter-confidence').val();
    const dateFilter = $('#filter-date').val();
    
    const now = new Date();
    let dateFrom = null;
    
    switch(dateFilter) {
        case 'today':
            dateFrom = now.toISOString().split('T')[0];
            break;
        case 'week':
            const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
            dateFrom = weekAgo.toISOString().split('T')[0];
            break;
        case 'month':
            const monthAgo = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate());
            dateFrom = monthAgo.toISOString().split('T')[0];
            break;
    }
    
    $('.prediction-row').each(function() {
        const row = $(this);
        const drug = row.data('drug');
        const confidence = row.data('confidence');
        const date = row.data('date');
        
        let show = true;
        
        // Drug filter
        if (drugFilter && !drug.includes(drugFilter)) {
            show = false;
        }
        
        // Confidence filter
        if (confidenceFilter && confidence !== confidenceFilter) {
            show = false;
        }
        
        // Date filter
        if (dateFrom && date < dateFrom) {
            show = false;
        }
        
        if (show) {
            row.show();
        } else {
            row.hide();
        }
    });
    
    // Update visible count
    const visibleRows = $('.prediction-row:visible').length;
    $('.card-title').html(`<i class="fas fa-table text-primary"></i> All Predictions (${visibleRows} shown)`);
}

function clearFilters() {
    $('#filter-drug').val('');
    $('#filter-confidence').val('');
    $('#filter-date').val('');
    $('.prediction-row').show();
    $('.card-title').html(`<i class="fas fa-table text-primary"></i> All Predictions ({{ $predictions->total() }} total)`);
}

function viewPrediction(id) {
    $('#predictionModal').modal('show');
    
    // Here you could load detailed information via AJAX
    // For now, we'll show a placeholder
    setTimeout(() => {
        $('#modal-content').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6>Prediction Information</h6>
                    <p><strong>ID:</strong> ${id}</p>
                    <p><strong>Status:</strong> <span class="badge badge-success">Completed</span></p>
                </div>
                <div class="col-md-6">
                    <h6>Model Information</h6>
                    <p><strong>Algorithm:</strong> GRU Neural Network</p>
                    <p><strong>Training Data:</strong> 7 medicines</p>
                </div>
            </div>
            <hr>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                This prediction was generated using our AI model trained on historical sales data.
            </div>
        `);
    }, 1000);
}

function deletePrediction(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This prediction will be permanently deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ea5455',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Yes, delete it!',
        cancelButtonText: '<i class="fas fa-times"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("demand-forecast.delete-prediction", ":id") }}'.replace(':id', id),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Prediction has been deleted.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Remove row with animation
                        $(`.prediction-row:has([onclick="deletePrediction(${id})"])`).fadeOut(300, function() {
                            $(this).remove();
                            filterTable(); // Update count
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Unable to delete prediction.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }
    });
}

// Add some interactive features
$(document).ready(function() {
    // Animate stats cards on load
    $('.stats-card').each(function(index) {
        $(this).delay(index * 100).animate({
            opacity: 1,
            transform: 'translateY(0)'
        }, 500);
    });
    
    // Add hover effects to table rows
    $('.prediction-row').hover(
        function() {
            $(this).addClass('table-hover-effect');
        },
        function() {
            $(this).removeClass('table-hover-effect');
        }
    );
});
</script>
@endpush