@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
<style>
    .ai-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .prediction-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .prediction-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .ai-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
    }

    .prediction-input-section {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .sales-input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .sales-input {
        flex: 1;
        text-align: center;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px;
        font-weight: 600;
    }

    .sales-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .week-label {
        font-size: 12px;
        color: #6c757d;
        text-align: center;
        margin-top: 5px;
    }

    .prediction-result {
        background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-top: 1rem;
        transform: scale(0);
        transition: all 0.5s ease;
    }

    .prediction-result.show {
        transform: scale(1);
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .result-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .result-value {
        font-weight: 700;
        font-size: 1.2rem;
    }

    .confidence-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    .confidence-high {
        background: rgba(40, 199, 111, 0.2);
        color: #28c76f;
    }

    .confidence-medium {
        background: rgba(255, 159, 67, 0.2);
        color: #ff9f43;
    }

    .confidence-low {
        background: rgba(234, 84, 85, 0.2);
        color: #ea5455;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .quick-fill-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .quick-fill-btn {
        padding: 8px 16px;
        border: 2px solid #667eea;
        background: transparent;
        color: #667eea;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quick-fill-btn:hover {
        background: #667eea;
        color: white;
    }

    .api-status {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        margin-bottom: 1rem;
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-online {
        background: #28c76f;
    }

    .status-offline {
        background: #ea5455;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .prediction-history-table {
        font-size: 14px;
    }

    .prediction-history-table td {
        vertical-align: middle;
    }

    .drug-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 16px;
        background: white;
    }

    .drug-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    @media (max-width: 768px) {
        .ai-header {
            padding: 1.5rem;
        }
        
        .prediction-input-section {
            padding: 1.5rem;
        }
        
        .sales-input-group {
            flex-direction: column;
        }
        
        .quick-fill-buttons {
            justify-content: center;
        }
    }
</style>
@endpush

@push('page-header')
<!-- AI Header -->
<div class="ai-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="ai-icon">
                <i class="fas fa-brain"></i>
            </div>
            <h2 class="mb-2">AI Demand Forecasting 🤖</h2>
            <p class="mb-0 opacity-75">Get intelligent predictions for medicine demand and optimize your inventory orders</p>
        </div>
        <div class="col-md-4 text-md-end">
            @if(isset($health) && $health['status'])
                <div class="api-status">
                    <div class="status-indicator status-online"></div>
                    <span>AI Model Online</span>
                </div>
            @else
                <div class="api-status">
                    <div class="status-indicator status-offline"></div>
                    <span>AI Model Offline</span>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="col-sm-12">
    <h3 class="page-title">Demand Forecasting</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Demand Forecasting</li>
    </ul>
</div>
@endpush

@section('content')

@if(isset($error))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ $error }}
        <br><small>Make sure the Python API is running: <code>python prediction_api_fixed.py</code></small>
    </div>
@endif

<div class="row">
    <!-- Prediction Input Section -->
    <div class="col-lg-8">
        <div class="card prediction-card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-calculator text-primary me-2"></i>
                    Make Prediction
                </h4>
            </div>
            <div class="card-body">
                <div class="prediction-input-section">
                    <form id="prediction-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="drug_name" class="form-label">
                                        <i class="fas fa-pills"></i> Select Medicine
                                    </label>
                                    <select name="drug_name" id="drug_name" class="form-control drug-select" required>
                                        <option value="">Choose a medicine...</option>
                                        @if(isset($availableDrugs))
                                            @foreach($availableDrugs as $drug)
                                                <option value="{{ $drug }}">{{ $drug }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-history"></i> Quick Fill Options
                                    </label>
                                    <div class="quick-fill-buttons">
                                        <button type="button" class="quick-fill-btn" onclick="quickFill([20, 25, 30])">Low Sales</button>
                                        <button type="button" class="quick-fill-btn" onclick="quickFill([40, 45, 50])">Medium Sales</button>
                                        <button type="button" class="quick-fill-btn" onclick="quickFill([70, 75, 80])">High Sales</button>
                                        <button type="button" class="quick-fill-btn" onclick="getHistoricalData()">Get Historical</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-chart-line"></i> Recent Sales Data (Last 3 Weeks)
                            </label>
                            <div class="sales-input-group">
                                <div>
                                    <input type="number" name="week1" class="form-control sales-input" placeholder="0" min="0" step="0.01" required>
                                    <div class="week-label">Week 1</div>
                                </div>
                                <div>
                                    <input type="number" name="week2" class="form-control sales-input" placeholder="0" min="0" step="0.01" required>
                                    <div class="week-label">Week 2</div>
                                </div>
                                <div>
                                    <input type="number" name="week3" class="form-control sales-input" placeholder="0" min="0" step="0.01" required>
                                    <div class="week-label">Week 3 (Latest)</div>
                                </div>
                            </div>
                            <small class="text-muted">Enter the quantity sold for each of the last 3 weeks</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-magic"></i> Generate AI Prediction
                        </button>
                    </form>

                    <!-- Loading Spinner -->
                    <div class="loading-spinner" id="loading-spinner">
                        <div class="spinner"></div>
                        <p class="mt-3 text-muted">AI is analyzing your data...</p>
                    </div>

                    <!-- Prediction Results -->
                    <div class="prediction-result" id="prediction-result">
                        <h5><i class="fas fa-brain"></i> AI Prediction Results</h5>
                        <div class="result-item">
                            <span>Predicted Demand:</span>
                            <span class="result-value" id="predicted-demand">0</span>
                        </div>
                        <div class="result-item">
                            <span>Suggested Order:</span>
                            <span class="result-value" id="suggested-order">0</span>
                        </div>
                        <div class="result-item">
                            <span>Confidence Level:</span>
                            <span class="confidence-badge" id="confidence-badge">Medium</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="card prediction-card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-chart-pie text-info"></i>
                    Quick Stats
                </h4>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-4">
                        <h3 class="text-primary">{{ isset($availableDrugs) ? count($availableDrugs) : 0 }}</h3>
                        <p class="text-muted mb-0">Trained Medicines</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-success">{{ isset($recentPredictions) ? count($recentPredictions) : 0 }}</h3>
                        <p class="text-muted mb-0">Recent Predictions</p>
                    </div>

                    @if(isset($health) && $health['status'])
                        <div class="alert alert-success p-3">
                            <i class="fas fa-check-circle"></i>
                            <strong>AI Model Ready</strong>
                            <br><small>Predictions available for {{ isset($availableDrugs) ? count($availableDrugs) : 0 }} medicines</small>
                        </div>
                    @else
                        <div class="alert alert-warning p-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>AI Model Offline</strong>
                            <br><small>Start the prediction service to use AI features</small>
                        </div>
                    @endif

                    <a href="{{ route('demand-forecast.history') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-history"></i> View History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Predictions -->
@if(isset($recentPredictions) && count($recentPredictions) > 0)
<div class="row">
    <div class="col-12">
        <div class="card prediction-card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-clock text-warning"></i>
                    Recent Predictions
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover prediction-history-table">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Predicted Demand</th>
                                <th>Suggested Order</th>
                                <th>Confidence</th>
                                <th>Date</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPredictions as $prediction)
                                <tr>
                                    <td>
                                        <strong>{{ $prediction->drug_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ number_format($prediction->predicted_demand, 1) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ number_format($prediction->suggested_order, 1) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $prediction->confidence_badge_class }}">
                                            {{ ucfirst($prediction->confidence) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $prediction->formatted_created_at }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $prediction->user->name }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('page-js')
<script>
$(document).ready(function() {
    // Form submission
    $('#prediction-form').on('submit', function(e) {
        e.preventDefault();
        
        const drugName = $('#drug_name').val();
        const week1 = parseFloat($('input[name="week1"]').val()) || 0;
        const week2 = parseFloat($('input[name="week2"]').val()) || 0;
        const week3 = parseFloat($('input[name="week3"]').val()) || 0;
        
        if (!drugName) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please select a medicine first!'
            });
            return;
        }
        
        if (week1 === 0 && week2 === 0 && week3 === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Sales Data',
                text: 'Please enter at least some sales data for the weeks!'
            });
            return;
        }
        
        // Show loading
        $('#loading-spinner').show();
        $('#prediction-result').removeClass('show');
        
        // Make prediction request
        $.ajax({
            url: '{{ route("demand-forecast.predict") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                drug_name: drugName,
                recent_sales: [week1, week2, week3]
            },
            success: function(response) {
                $('#loading-spinner').hide();
                
                if (response.success) {
                    const prediction = response.prediction;
                    
                    // Update result display
                    $('#predicted-demand').text(prediction.predicted_demand.toFixed(1));
                    $('#suggested-order').text(prediction.suggested_order.toFixed(1));
                    
                    // Update confidence badge
                    const confidenceBadge = $('#confidence-badge');
                    confidenceBadge.removeClass('confidence-high confidence-medium confidence-low');
                    confidenceBadge.addClass('confidence-' + prediction.confidence);
                    confidenceBadge.text(prediction.confidence.charAt(0).toUpperCase() + prediction.confidence.slice(1));
                    
                    // Show result with animation
                    $('#prediction-result').addClass('show');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Prediction Complete!',
                        text: `Suggested order: ${prediction.suggested_order.toFixed(1)} units`,
                        timer: 3000,
                        showConfirmButton: false
                    });
                    
                    // Refresh page after 3 seconds to show new prediction in history
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Prediction Failed',
                        text: response.error || 'Unable to generate prediction'
                    });
                }
            },
            error: function(xhr) {
                $('#loading-spinner').hide();
                
                let errorMessage = 'Unable to connect to AI service';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: errorMessage,
                    footer: '<small>Make sure the Python AI service is running</small>'
                });
            }
        });
    });
});

// Quick fill functions
function quickFill(values) {
    $('input[name="week1"]').val(values[0]);
    $('input[name="week2"]').val(values[1]);
    $('input[name="week3"]').val(values[2]);
    
    // Add a subtle animation
    $('.sales-input').addClass('border-success');
    setTimeout(() => {
        $('.sales-input').removeClass('border-success');
    }, 1000);
}

function getHistoricalData() {
    const drugName = $('#drug_name').val();
    if (!drugName) {
        Swal.fire({
            icon: 'info',
            title: 'Select Medicine First',
            text: 'Please select a medicine to get historical data'
        });
        return;
    }
    
    Swal.fire({
        title: 'Fetching Historical Data...',
        text: 'Getting sales data for ' + drugName,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: '{{ route("demand-forecast.historical-sales") }}',
        method: 'GET',
        data: {
            drug_name: drugName,
            weeks: 3
        },
        success: function(response) {
            Swal.close();
            
            if (response.success && response.sales.length >= 3) {
                const sales = response.sales.slice(-3); // Last 3 weeks
                quickFill(sales);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Historical Data Loaded',
                    text: `Loaded ${sales.length} weeks of sales data`,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Historical Data',
                    text: 'No sufficient historical sales data found for this medicine'
                });
            }
        },
        error: function() {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Unable to fetch historical data'
            });
        }
    });
}

// Real-time validation
$('.sales-input').on('input', function() {
    const value = parseFloat($(this).val());
    if (value < 0) {
        $(this).val(0);
    }
    
    // Visual feedback for valid input
    if (value > 0) {
        $(this).addClass('is-valid').removeClass('is-invalid');
    } else {
        $(this).removeClass('is-valid is-invalid');
    }
});

// Enhanced drug selection
$('#drug_name').on('change', function() {
    const selectedDrug = $(this).val();
    if (selectedDrug) {
        $(this).addClass('is-valid');
        
        // Clear previous inputs
        $('.sales-input').val('').removeClass('is-valid is-invalid');
        $('#prediction-result').removeClass('show');
    } else {
        $(this).removeClass('is-valid');
    }
});

// Initialize tooltips if using Bootstrap
$('[data-toggle="tooltip"]').tooltip();

// Auto-save draft functionality (optional)
let draftTimer;
$('#prediction-form input, #prediction-form select').on('input change', function() {
    clearTimeout(draftTimer);
    draftTimer = setTimeout(saveDraft, 2000);
});

function saveDraft() {
    const draft = {
        drug_name: $('#drug_name').val(),
        week1: $('input[name="week1"]').val(),
        week2: $('input[name="week2"]').val(),
        week3: $('input[name="week3"]').val()
    };
    localStorage.setItem('prediction_draft', JSON.stringify(draft));
}

function loadDraft() {
    const draft = localStorage.getItem('prediction_draft');
    if (draft) {
        const data = JSON.parse(draft);
        $('#drug_name').val(data.drug_name);
        $('input[name="week1"]').val(data.week1);
        $('input[name="week2"]').val(data.week2);
        $('input[name="week3"]').val(data.week3);
    }
}

// Load draft on page load
$(document).ready(function() {
    loadDraft();
});
</script>
@endpush