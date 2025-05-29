@extends('admin.layouts.app')

@push('page-css')
<style>
    .invoice-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 30px;
    }
    
    .invoice-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 15px 15px 0 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        display: block;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending { background: #fff3cd; color: #856404; }
    .status-paid { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    
    .invoice-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Invoice Management</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Invoices</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Statistics -->
        <div class="invoice-card">
            <div class="invoice-header">
                <h4 style="margin: 0; font-weight: 600;">
                    <i class="fas fa-chart-line mr-2"></i>
                    Invoice Statistics
                </h4>
            </div>
            <div class="p-4">
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number">{{ $stats['total_invoices'] }}</span>
                        <div class="stat-label">Total Invoices</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ $stats['pending_invoices'] }}</span>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ $stats['paid_invoices'] }}</span>
                        <div class="stat-label">Paid</div>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">${{ number_format($stats['total_revenue'], 2) }}</span>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice List -->
        <div class="invoice-card">
            <div class="invoice-header">
                <h4 style="margin: 0; font-weight: 600;">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Recent Invoices
                </h4>
            </div>
            <div class="invoice-table">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fc;">
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>
                                <strong>{{ $invoice->invoice_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $invoice->customer_name }}</strong>
                                    @if($invoice->customer_phone)
                                        <br><small class="text-muted">{{ $invoice->customer_phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-info">{{ $invoice->sales->count() }} items</span>
                            </td>
                            <td>
                                <strong>${{ number_format($invoice->total_amount, 2) }}</strong>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $invoice->status }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.invoices.print', $invoice) }}" 
                                       class="btn btn-secondary btn-sm" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if($invoice->status === 'pending')
                                    <form action="{{ route('admin.invoices.mark-paid', $invoice) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                    <p>No invoices found. <a href="{{ route('admin.invoices.create') }}">Create your first invoice</a></p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($invoices->hasPages())
            <div class="p-3">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('page-js')
<script>
function convertSalesToInvoices() {
    if (!confirm('This will convert all sales without invoices into grouped invoices. Continue?')) {
        return;
    }

    fetch('{{ route("admin.invoices.convert-sales") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Success: ' + data.message);
            window.location.reload();
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Error: Failed to convert sales');
    });
}
</script>
@endpush