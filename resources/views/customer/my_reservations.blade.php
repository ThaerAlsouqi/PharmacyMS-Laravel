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
                                    <h3 class="mb-0 fw-bold">2</h3>
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
                                    <h3 class="mb-0 fw-bold">1</h3>
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
                                    <h3 class="mb-0 fw-bold">8</h3>
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
                                    <h3 class="mb-0 fw-bold">1</h3>
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
                                <i class="fas fa-spinner me-2"></i> Active Reservations (3)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-reservations" type="button" role="tab" aria-controls="past-reservations" aria-selected="false">
                                <i class="fas fa-history me-2"></i> Past Reservations (8)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled-reservations" type="button" role="tab" aria-controls="cancelled-reservations" aria-selected="false">
                                <i class="fas fa-ban me-2"></i> Cancelled (1)
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-purple"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Search by reservation ID or medicine name...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>Filter by date</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                                <option>Last 6 months</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>Filter by pharmacy</option>
                                <option>Main Street Pharmacy</option>
                                <option>Central Pharmacy</option>
                                <option>Westside Drugstore</option>
                                <option>Healthcare Pharmacy</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="reservationTabContent">
                <!-- Active Reservations Tab -->
                <div class="tab-pane fade show active" id="active-reservations" role="tabpanel" aria-labelledby="active-tab">
                    <!-- Reservation 1 -->
                    <div class="card border-0 shadow-sm mb-4 hover-card">
                        <div class="card-header bg-light-gradient border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="mb-0 text-purple">Reservation #MF-2023-1089</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> May 7, 2023
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="1">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 reservation-details" id="reservation-details-1" style="display: none;">
                            <div class="p-4">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Pickup Information</h6>
                                        <p class="mb-1"><strong>Pharmacy:</strong> Main Street Pharmacy</p>
                                        <p class="mb-1"><strong>Address:</strong> 123 Main St, Anytown, ST 12345</p>
                                        <p class="mb-1"><strong>Phone:</strong> 0798030585</p>
                                        <p class="mb-0"><strong>Estimated Pickup:</strong> May 9, 2023</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Reservation Summary</h6>
                                        <p class="mb-1"><strong>Items:</strong> 3</p>
                                        <p class="mb-1"><strong>Total:</strong> $45.75</p>
                                        <p class="mb-1"><strong>Payment Method:</strong> Pay at Pickup</p>
                                        <p class="mb-0"><strong>Status:</strong> Awaiting pharmacy confirmation</p>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Paracetamol-500m-Caplets-32.jpg" alt="Paracetamol" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Paracetamol 500mg</h6>
                                                            <small class="text-muted">20 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Pain Relief</td>
                                                <td>2</td>
                                                <td>$9.99</td>
                                                <td>$19.98</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Vitamin c Complex.JPG" alt="Vitamin C" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Vitamin C 1000mg</h6>
                                                            <small class="text-muted">30 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Vitamins</td>
                                                <td>1</td>
                                                <td>$15.50</td>
                                                <td>$15.50</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Adhesive Bandages.jpg" alt="Bandages" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Adhesive Bandages</h6>
                                                            <small class="text-muted">Pack of 30</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>First Aid</td>
                                                <td>1</td>
                                                <td>$7.50</td>
                                                <td>$7.50</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                <td>$2.77</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-purple fw-bold">$45.75</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-danger me-2">
                                        <i class="fas fa-times me-1"></i> Cancel Reservation
                                    </button>
                                    <button class="btn btn-purple">
                                        <i class="fas fa-print me-1"></i> Print Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation 2 -->
                    <div class="card border-0 shadow-sm mb-4 hover-card">
                        <div class="card-header bg-light-gradient border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="mb-0 text-purple">Reservation #MF-2023-1075</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> May 5, 2023
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="2">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 reservation-details" id="reservation-details-2" style="display: none;">
                            <div class="p-4">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Pickup Information</h6>
                                        <p class="mb-1"><strong>Pharmacy:</strong> Central Pharmacy</p>
                                        <p class="mb-1"><strong>Address:</strong> 456 Center Ave, Anytown, ST 12345</p>
                                        <p class="mb-1"><strong>Phone:</strong> 0798030585</p>
                                        <p class="mb-0"><strong>Estimated Pickup:</strong> May 8, 2023</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Reservation Summary</h6>
                                        <p class="mb-1"><strong>Items:</strong> 2</p>
                                        <p class="mb-1"><strong>Total:</strong> $28.25</p>
                                        <p class="mb-1"><strong>Payment Method:</strong> Pay at Pickup</p>
                                        <p class="mb-0"><strong>Status:</strong> Awaiting pharmacy confirmation</p>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/IBUPROFEN20200mg.jpg" alt="Ibuprofen" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Ibuprofen 200mg</h6>
                                                            <small class="text-muted">30 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Anti-inflammatory</td>
                                                <td>1</td>
                                                <td>$12.25</td>
                                                <td>$12.25</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Loratadine10mg.jpg" alt="Loratadine" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Loratadine 10mg</h6>
                                                            <small class="text-muted">14 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Antihistamine</td>
                                                <td>1</td>
                                                <td>$14.99</td>
                                                <td>$14.99</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                <td>$1.01</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-purple fw-bold">$28.25</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-danger me-2">
                                        <i class="fas fa-times me-1"></i> Cancel Reservation
                                    </button>
                                    <button class="btn btn-purple">
                                        <i class="fas fa-print me-1"></i> Print Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation 3 -->
                    <div class="card border-0 shadow-sm mb-4 hover-card">
                        <div class="card-header bg-light-gradient border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="mb-0 text-purple">Reservation #MF-2023-1062</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> May 3, 2023
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-box me-1"></i> Ready for Pickup
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="3">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 reservation-details" id="reservation-details-3" style="display: none;">
                            <div class="p-4">
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> Your order is ready for pickup! Please bring your ID and reservation number.
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Pickup Information</h6>
                                        <p class="mb-1"><strong>Pharmacy:</strong> Westside Drugstore</p>
                                        <p class="mb-1"><strong>Address:</strong> 789 West Blvd, Anytown, ST 12345</p>
                                        <p class="mb-1"><strong>Phone:</strong> 0798030585</p>
                                        <p class="mb-0"><strong>Pickup By:</strong> May 10, 2023</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Reservation Summary</h6>
                                        <p class="mb-1"><strong>Items:</strong> 1</p>
                                        <p class="mb-1"><strong>Total:</strong> $19.75</p>
                                        <p class="mb-1"><strong>Payment Method:</strong> Pay at Pickup</p>
                                        <p class="mb-0"><strong>Status:</strong> Ready for pickup since May 6, 2023</p>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Vitamin D3 1000 IU.jpg" alt="Vitamin D" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Vitamin D3 1000 IU</h6>
                                                            <small class="text-muted">90 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Vitamins</td>
                                                <td>1</td>
                                                <td>$19.75</td>
                                                <td>$19.75</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                <td>$0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-purple fw-bold">$19.75</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-map-marker-alt me-1"></i> Get Directions
                                    </button>
                                    <button class="btn btn-purple">
                                        <i class="fas fa-print me-1"></i> Print Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Past Reservations Tab -->
                <div class="tab-pane fade" id="past-reservations" role="tabpanel" aria-labelledby="past-tab">
                    <!-- Past Reservation 1 -->
                    <div class="card border-0 shadow-sm mb-4 hover-card">
                        <div class="card-header bg-light-gradient border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="mb-0 text-purple">Reservation #MF-2023-1045</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> April 28, 2023
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Completed
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="4">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 reservation-details" id="reservation-details-4" style="display: none;">
                            <div class="p-4">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Pickup Information</h6>
                                        <p class="mb-1"><strong>Pharmacy:</strong> Main Street Pharmacy</p>
                                        <p class="mb-1"><strong>Address:</strong> 123 Main St, Anytown, ST 12345</p>
                                        <p class="mb-1"><strong>Phone:</strong> 0798030585</p>
                                        <p class="mb-0"><strong>Picked Up On:</strong> April 30, 2023</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Reservation Summary</h6>
                                        <p class="mb-1"><strong>Items:</strong> 2</p>
                                        <p class="mb-1"><strong>Total:</strong> $32.49</p>
                                        <p class="mb-1"><strong>Payment Method:</strong> Credit Card</p>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Paracetamol-500m-Caplets-32.jpg" alt="Paracetamol" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Paracetamol 500mg</h6>
                                                            <small class="text-muted">20 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Pain Relief</td>
                                                <td>1</td>
                                                <td>$9.99</td>
                                                <td>$9.99</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Multivitamin Complex.jpg" alt="Multivitamin" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Multivitamin Complex</h6>
                                                            <small class="text-muted">60 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Vitamins</td>
                                                <td>1</td>
                                                <td>$22.50</td>
                                                <td>$22.50</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                <td>$0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-purple fw-bold">$32.49</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-redo me-1"></i> Reorder
                                    </button>
                                    <button class="btn btn-purple">
                                        <i class="fas fa-print me-1"></i> Print Receipt
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- More past reservations would be listed here -->
                    <div class="text-center my-4">
                        <button class="btn btn-outline-purple">
                            <i class="fas fa-history me-1"></i> Load More Past Reservations
                        </button>
                    </div>
                </div>

                <!-- Cancelled Reservations Tab -->
                <div class="tab-pane fade" id="cancelled-reservations" role="tabpanel" aria-labelledby="cancelled-tab">
                    <!-- Cancelled Reservation -->
                    <div class="card border-0 shadow-sm mb-4 hover-card">
                        <div class="card-header bg-light-gradient border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h5 class="mb-0 text-purple">Reservation #MF-2023-1050</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> April 30, 2023
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i> Cancelled
                                    </span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-sm btn-outline-purple reservation-details-btn" data-reservation="5">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 reservation-details" id="reservation-details-5" style="display: none;">
                            <div class="p-4">
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> This reservation was cancelled on May 1, 2023.
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Pickup Information</h6>
                                        <p class="mb-1"><strong>Pharmacy:</strong> Central Pharmacy</p>
                                        <p class="mb-1"><strong>Address:</strong> 456 Center Ave, Anytown, ST 12345</p>
                                        <p class="mb-1"><strong>Phone:</strong> 0798030585</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-purple mb-3">Reservation Summary</h6>
                                        <p class="mb-1"><strong>Items:</strong> 1</p>
                                        <p class="mb-1"><strong>Total:</strong> $15.50</p>
                                        <p class="mb-1"><strong>Cancellation Reason:</strong> Customer request</p>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="/Vitamin C 1000mg.jpg" alt="Vitamin C" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div class="ms-3">
                                                            <h6 class="mb-0">Vitamin C 1000mg</h6>
                                                            <small class="text-muted">30 tablets</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Vitamins</td>
                                                <td>1</td>
                                                <td>$15.50</td>
                                                <td>$15.50</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                                <td>$0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-purple fw-bold">$15.50</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-redo me-1"></i> Reorder
                                    </button>
                                    <button class="btn btn-purple">
                                        <i class="fas fa-print me-1"></i> Print Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty state if no cancelled reservations -->
                    <div class="text-center my-4 d-none">
                        <div class="py-5">
                            <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                            <h5>No Cancelled Reservations</h5>
                            <p class="text-muted">You don't have any cancelled reservations.</p>
                        </div>
                    </div>
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
