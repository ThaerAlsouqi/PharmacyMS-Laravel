@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    <link rel="stylesheet" href="{{asset('assets/plugins/chart.js/Chart.min.css')}}">
    <style>
        /* Custom CSS for improved UI/UX */
        .dashboard-welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .dash-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .dash-widget-icon-new {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .dash-card:hover .dash-widget-icon-new {
            transform: scale(1.1);
        }

        .icon-success {
            background: rgba(40, 199, 111, 0.1);
            color: #28c76f;
        }

        .icon-info {
            background: rgba(0, 207, 232, 0.1);
            color: #00cfe8;
        }

        .icon-danger {
            background: rgba(234, 84, 85, 0.1);
            color: #ea5455;
        }

        .icon-warning {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
        }

        .dash-count h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .dash-widget-info h6 {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .progress {
            height: 6px;
            border-radius: 3px;
            background-color: #f0f0f0;
        }

        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .chart-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        /* DataTable customization */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #667eea !important;
            border-color: #667eea !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8f9fa !important;
            border-color: #667eea !important;
            color: #667eea !important;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .dashboard-welcome {
                padding: 1.5rem;
            }
            
            .dash-count h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@push('page-header')
<!-- Welcome Section -->
<div class="dashboard-welcome">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">Welcome back, {{auth()->user()->name}}! 👋</h2>
            <p class="mb-0 opacity-75">Here's what's happening with your pharmacy today.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <p class="mb-0"><i class="fe fe-calendar"></i> {{ date('l, F j, Y') }}</p>
            <p class="mb-0"><i class="fe fe-clock"></i> <span id="current-time">{{ date('h:i A') }}</span></p>
        </div>
    </div>
</div>

<div class="col-sm-12">
	<h3 class="page-title">Dashboard</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active">Dashboard</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Today's Sales</h6>
                        <div class="dash-count">
                            <h3>{{AppSettings::get('app_currency', '$')}} {{$today_sales}}</h3>
                        </div>
                        <div class="dash-widget-info mt-3">
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 65%"></div>
                            </div>
                            <small class="text-muted">65% of daily target</small>
                        </div>
                    </div>
                    <div class="dash-widget-icon-new icon-success">
                        <i class="fe fe-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Available Categories</h6>
                        <div class="dash-count">
                            <h3>{{$total_categories}}</h3>
                        </div>
                        <div class="dash-widget-info mt-3">
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                            <small class="text-muted">All medicine types</small>
                        </div>
                    </div>
                    <div class="dash-widget-icon-new icon-info">
                        <i class="fa fa-th-large"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Expired Medicines</h6>
                        <div class="dash-count">
                            <h3 class="text-danger">{{$total_expired_products}}</h3>
                        </div>
                        <div class="dash-widget-info mt-3">
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: {{$total_expired_products > 0 ? '100' : '0'}}%"></div>
                            </div>
                            <small class="text-muted">Requires attention</small>
                        </div>
                    </div>
                    <div class="dash-widget-icon-new icon-danger">
                        <i class="fe fe-folder"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">System Users</h6>
                        <div class="dash-count">
                            <h3>{{\DB::table('users')->count()}}</h3>
                        </div>
                        <div class="dash-widget-info mt-3">
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 100%"></div>
                            </div>
                            <small class="text-muted">Active accounts</small>
                        </div>
                    </div>
                    <div class="dash-widget-icon-new icon-warning">
                        <i class="fe fe-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-7">
        <div class="card card-table p-3 table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Recent Sales List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="sales-table" class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                                                                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-5">
                    
        <!-- Pie Chart -->
        <div class="card card-chart chart-card">
            <div class="card-header">
                <h4 class="card-title text-center">Graph Report</h4>
            </div>
            <div class="card-body">
                <div style="">
                    {!! $pieChart->render() !!}
                </div>
            </div>
        </div>
        <!-- /Pie Chart -->
        
    </div>	
    
    
</div>


@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('sales.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'quantity', name: 'quantity'},
                {data: 'total_price', name: 'total_price'},
				{data: 'date', name: 'date'},
            ],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search sales..."
            }
        });
        
        // Update time every second
        setInterval(function() {
            var now = new Date();
            var timeString = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            $('#current-time').text(timeString);
        }, 1000);
    });
</script> 
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endpush