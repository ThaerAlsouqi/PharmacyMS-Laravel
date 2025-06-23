@extends('customer.layout.app')

@section('title', 'My Reservations')

@section('content')
    <!-- Header Section -->
    <section class="py-4 bg-light-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Your Orders
                    </div>
                    <h1 class="display-5 fw-bold text-gradient mb-2">My Reservations</h1>
                    <p class="lead text-secondary">
                        Track and manage your medicine reservations from our pharmacy.
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light-purple p-3 me-3">
                                    <i class="fas fa-headset fa-2x text-purple"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Need Help?</h5>
                                    <p class="mb-0 small">Contact our support team at <strong>mohammad23altill@gmail.com</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <!-- Reservation Stats -->
            <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light-purple p-3 me-3">
                                    <i class="fas fa-clock fa-2x text-purple"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'pending')->count() }}</h3>
                                    <p class="mb-0 text-muted">Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light-purple p-3 me-3">
                                    <i class="fas fa-box fa-2x text-purple"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'ready')->count() }}</h3>
                                    <p class="mb-0 text-muted">Ready for Pickup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light-purple p-3 me-3">
                                    <i class="fas fa-check-circle fa-2x text-purple"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'completed')->count() }}</h3>
                                    <p class="mb-0 text-muted">Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light-purple p-3 me-3">
                                    <i class="fas fa-times-circle fa-2x text-purple"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                                    <p class="mb-0 text-muted">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Tabs -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <ul class="nav nav-pills nav-fill p-3 bg-light-gradient" id="reservationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-reservations" type="button" role="tab" aria-controls="active-reservations" aria-selected="true">
                                <i class="fas fa-spinner me-2"></i> Active Reservations ({{ $reservations->whereIn('status', ['pending', 'ready'])->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-reservations" type="button" role="tab" aria-controls="past-reservations" aria-selected="false">
                                <i class="fas fa-history me-2"></i> Past Reservations ({{ $reservations->where('status', 'completed')->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled-reservations" type="button" role="tab" aria-controls="cancelled-reservations" aria-selected="false">
                                <i class="fas fa-ban me-2"></i> Cancelled ({{ $reservations->where('status', 'cancelled')->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="reservationTabContent">
                <!-- Active Reservations Tab -->
                <div class="tab-pane fade show active" id="active-reservations" role="tabpanel" aria-labelledby="active-tab">
                    @php $activeReservations = $reservations->whereIn('status', ['pending', 'ready']) @endphp
                    @if($activeReservations->count() > 0)
                        @foreach($activeReservations as $reservation)
                            <div class="card border-0 shadow-sm mb-4 hover-card">
                                <div class="card-header bg-light-gradient border-0 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h5 class="mb-0 text-purple">Reservation #{{ $reservation->reservation_number }}</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i> {{ $reservation->created_at->format('M j, Y') }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            @if($reservation->status == 'pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @elseif($reservation->status == 'ready')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-box me-1"></i> Ready for Pickup
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="{{ $reservation->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0 reservation-details" id="reservation-details-{{ $reservation->id }}" style="display: none;">
                                    <div class="p-4">
                                        @if($reservation->status == 'ready')
                                            <div class="alert alert-success" role="alert">
                                                <i class="fas fa-check-circle me-2"></i> Your order is ready for pickup! Please bring your ID and reservation number.
                                            </div>
                                        @endif
                                        
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Pickup Information</h6>
                                                <p class="mb-1"><strong>Pharmacy:</strong> {{ $reservation->pharmacy_name }}</p>
                                                <p class="mb-1"><strong>Address:</strong> {{ $reservation->pharmacy_address }}</p>
                                                <p class="mb-1"><strong>Phone:</strong> {{ $reservation->pharmacy_phone }}</p>
                                                @if($reservation->status == 'ready')
                                                    <p class="mb-0"><strong>Pickup By:</strong> {{ $reservation->estimated_pickup_date?->format('M j, Y') }}</p>
                                                @else
                                                    <p class="mb-0"><strong>Estimated Pickup:</strong> {{ $reservation->estimated_pickup_date?->format('M j, Y') }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Reservation Summary</h6>
                                                <p class="mb-1"><strong>Items:</strong> {{ $reservation->items->count() }}</p>
                                                <p class="mb-1"><strong>Total:</strong> ${{ number_format($reservation->total_amount, 2) }}</p>
                                                <p class="mb-1"><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $reservation->payment_method)) }}</p>
                                                @if($reservation->status == 'pending')
                                                    <p class="mb-0"><strong>Status:</strong> Awaiting pharmacy confirmation</p>
                                                @elseif($reservation->status == 'ready')
                                                    <p class="mb-0"><strong>Status:</strong> Ready for pickup since {{ $reservation->updated_at->format('M j, Y') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <h6 class="text-purple mb-3">Items in this Reservation</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Medicine</th>
                                                        <th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($reservation->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/' . ($item->purchase->image ?? 'default-medicine.jpg')) }}" alt="{{ $item->purchase->product }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    <div class="ms-3">
                                                                        <h6 class="mb-0">{{ $item->purchase->product }}</h6>
                                                                        <small class="text-muted">{{ $item->purchase->description ?? 'Medicine' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->purchase->category->name ?? 'General' }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                                            <td>${{ number_format($item->subtotal, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                        <td>${{ number_format($reservation->tax_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                        <td class="text-purple fw-bold">${{ number_format($reservation->total_amount, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            @if($reservation->status == 'pending')
                                                <form action="{{ route('customer.reservations.cancel', $reservation->id) }}" method="POST" class="me-2" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="fas fa-times me-1"></i> Cancel Reservation
                                                    </button>
                                                </form>
                                            @elseif($reservation->status == 'ready')
                                                <button class="btn btn-outline-secondary me-2">
                                                    <i class="fas fa-map-marker-alt me-1"></i> Get Directions
                                                </button>
                                            @endif
                                            
                                            <button class="btn btn-purple">
                                                <i class="fas fa-print me-1"></i> Print Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center my-5">
                            <div class="py-5">
                                <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                                <h5>No Active Reservations</h5>
                                <p class="text-muted">You don't have any active reservations at the moment.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Past Reservations Tab -->
                <div class="tab-pane fade" id="past-reservations" role="tabpanel" aria-labelledby="past-tab">
                    @php $pastReservations = $reservations->where('status', 'completed') @endphp
                    @if($pastReservations->count() > 0)
                        @foreach($pastReservations as $reservation)
                            <div class="card border-0 shadow-sm mb-4 hover-card">
                                <div class="card-header bg-light-gradient border-0 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h5 class="mb-0 text-purple">Reservation #{{ $reservation->reservation_number }}</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i> {{ $reservation->created_at->format('M j, Y') }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-secondary px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> Completed
                                            </span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="{{ $reservation->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0 reservation-details" id="reservation-details-{{ $reservation->id }}" style="display: none;">
                                    <div class="p-4">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Pickup Information</h6>
                                                <p class="mb-1"><strong>Pharmacy:</strong> {{ $reservation->pharmacy_name }}</p>
                                                <p class="mb-1"><strong>Address:</strong> {{ $reservation->pharmacy_address }}</p>
                                                <p class="mb-1"><strong>Phone:</strong> {{ $reservation->pharmacy_phone }}</p>
                                                <p class="mb-0"><strong>Picked Up On:</strong> {{ $reservation->updated_at->format('M j, Y') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Reservation Summary</h6>
                                                <p class="mb-1"><strong>Items:</strong> {{ $reservation->items->count() }}</p>
                                                <p class="mb-1"><strong>Total:</strong> ${{ number_format($reservation->total_amount, 2) }}</p>
                                                <p class="mb-1"><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $reservation->payment_method)) }}</p>
                                                <p class="mb-0"><strong>Status:</strong> Completed</p>
                                            </div>
                                        </div>

                                        <h6 class="text-purple mb-3">Items in this Reservation</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Medicine</th>
                                                        <th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($reservation->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/' . ($item->purchase->image ?? 'default-medicine.jpg')) }}" alt="{{ $item->purchase->product }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    <div class="ms-3">
                                                                        <h6 class="mb-0">{{ $item->purchase->product }}</h6>
                                                                        <small class="text-muted">{{ $item->purchase->description ?? 'Medicine' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->purchase->category->name ?? 'General' }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                                            <td>${{ number_format($item->subtotal, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                        <td>${{ number_format($reservation->tax_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                        <td class="text-purple fw-bold">${{ number_format($reservation->total_amount, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <form action="{{ route('customer.reservations.reorder', $reservation->id) }}" method="POST" class="me-2">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary">
                                                    <i class="fas fa-redo me-1"></i> Reorder
                                                </button>
                                            </form>
                                            <button class="btn btn-purple">
                                                <i class="fas fa-print me-1"></i> Print Receipt
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center my-5">
                            <div class="py-5">
                                <i class="fas fa-history fa-4x text-muted mb-3"></i>
                                <h5>No Past Reservations</h5>
                                <p class="text-muted">You don't have any completed reservations yet.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Cancelled Reservations Tab -->
                <div class="tab-pane fade" id="cancelled-reservations" role="tabpanel" aria-labelledby="cancelled-tab">
                    @php $cancelledReservations = $reservations->where('status', 'cancelled') @endphp
                    @if($cancelledReservations->count() > 0)
                        @foreach($cancelledReservations as $reservation)
                            <div class="card border-0 shadow-sm mb-4 hover-card">
                                <div class="card-header bg-light-gradient border-0 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h5 class="mb-0 text-purple">Reservation #{{ $reservation->reservation_number }}</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i> {{ $reservation->created_at->format('M j, Y') }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i> Cancelled
                                            </span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="{{ $reservation->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0 reservation-details" id="reservation-details-{{ $reservation->id }}" style="display: none;">
                                    <div class="p-4">
                                        <div class="alert alert-danger" role="alert">
                                            <i class="fas fa-info-circle me-2"></i> This reservation was cancelled on {{ $reservation->updated_at->format('M j, Y') }}.
                                        </div>
                                        
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Pickup Information</h6>
                                                <p class="mb-1"><strong>Pharmacy:</strong> {{ $reservation->pharmacy_name }}</p>
                                                <p class="mb-1"><strong>Address:</strong> {{ $reservation->pharmacy_address }}</p>
                                                <p class="mb-1"><strong>Phone:</strong> {{ $reservation->pharmacy_phone }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-purple mb-3">Reservation Summary</h6>
                                                <p class="mb-1"><strong>Items:</strong> {{ $reservation->items->count() }}</p>
                                                <p class="mb-1"><strong>Total:</strong> ${{ number_format($reservation->total_amount, 2) }}</p>
                                                <p class="mb-1"><strong>Cancellation Reason:</strong> {{ $reservation->cancellation_reason ?? 'Not specified' }}</p>
                                            </div>
                                        </div>

                                        <h6 class="text-purple mb-3">Items in this Reservation</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Medicine</th>
                                                        <th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($reservation->items as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/' . ($item->purchase->image ?? 'default-medicine.jpg')) }}" alt="{{ $item->purchase->product }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    <div class="ms-3">
                                                                        <h6 class="mb-0">{{ $item->purchase->product }}</h6>
                                                                        <small class="text-muted">{{ $item->purchase->description ?? 'Medicine' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->purchase->category->name ?? 'General' }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                                            <td>${{ number_format($item->subtotal, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                        <td>${{ number_format($reservation->tax_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                        <td class="text-purple fw-bold">${{ number_format($reservation->total_amount, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <form action="{{ route('customer.reservations.reorder', $reservation->id) }}" method="POST" class="me-2">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary">
                                                    <i class="fas fa-redo me-1"></i> Reorder
                                                </button>
                                            </form>
                                            <button class="btn btn-purple">
                                                <i class="fas fa-print me-1"></i> Print Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center my-5">
                            <div class="py-5">
                                <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                                <h5>No Cancelled Reservations</h5>
                                <p class="text-muted">You don't have any cancelled reservations.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle reservation details
        const detailButtons = document.querySelectorAll('.reservation-details-btn');
        
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                const reservationId = this.getAttribute('data-reservation');
                const detailsSection = document.getElementById('reservation-details-' + reservationId);
                
                if (detailsSection.style.display === 'none') {
                    detailsSection.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-chevron-up"></i>';
                } else {
                    detailsSection.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-chevron-down"></i>';
                }
            });
        });
    });
</script>
@endsection