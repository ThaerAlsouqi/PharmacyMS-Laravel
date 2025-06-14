@extends('customer.layout.app')

@section('title', 'Medicines')

@section('content')
    <!-- Header Section -->
    <section class="py-4 bg-light-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                        <i class="fas fa-pills me-2"></i>
                        Our Products
                    </div>
                    <h1 class="display-5 fw-bold text-gradient mb-2">Available Medicines</h1>
                    <p class="lead text-secondary">
                        Browse our extensive collection of {{ $medicines->total() }} medicines.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <form action="{{ route('medicines') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search medicines..." 
                                           name="search" value="{{ request('search') }}">
                                    <button class="btn btn-purple" type="submit">
                                        <i class="fas fa-search me-1"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light-gradient border-0">
                            <h5 class="mb-0 text-purple">
                                <i class="fas fa-filter me-2"></i> Filters
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('medicines') }}" method="GET">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <!-- Categories -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Categories</h6>
                                    @foreach($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               id="category{{ $category->id }}" 
                                               name="categories[]" 
                                               value="{{ $category->name }}"
                                               {{ in_array($category->name, request('categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Price Range -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Price Range</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="me-2">$</span>
                                        <input type="number" class="form-control form-control-sm" 
                                               placeholder="Min" name="min_price" min="0" 
                                               value="{{ request('min_price') }}">
                                        <span class="mx-2">-</span>
                                        <input type="number" class="form-control form-control-sm" 
                                               placeholder="Max" name="max_price" min="0"
                                               value="{{ request('max_price') }}">
                                    </div>
                                </div>

                                <!-- Availability -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Availability</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="availability" 
                                               id="all" value="all" 
                                               {{ request('availability', 'all') == 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="all">All</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="availability" 
                                               id="in-stock" value="in-stock"
                                               {{ request('availability') == 'in-stock' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="in-stock">In Stock</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-purple w-100">
                                    Apply Filters
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Medicine Listings -->
                <div class="col-lg-9">
                    <!-- Results Count -->
                    <p class="text-muted mb-4">
                        Showing {{ $medicines->firstItem() ?? 0 }}-{{ $medicines->lastItem() ?? 0 }} 
                        of {{ $medicines->total() }} results
                        @if(request('search'))
                            for "{{ request('search') }}"
                        @endif
                    </p>

                    @if($medicines->count() > 0)
                        <!-- Grid View -->
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="medicines-grid">
                            @foreach($medicines as $medicine)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="position-relative">
                                        <img src="{{ isset($medicine->image) 
                                                ? asset('storage/purchases/' . $medicine->image) 
                                                : asset('assets/img/default-product.png') }}" 
                                             class="card-img-top" 
                                             alt="{{ $medicine->product }}" 
                                             style="height: 200px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                        
                                        @if($medicine->quantity > 0)
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                        @else
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Out of Stock</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-light-purple text-purple">
                                                {{ $medicine->category->name ?? 'General' }}
                                            </span>
                                            <small class="text-muted">Stock: {{ $medicine->quantity }}</small>
                                        </div>
                                        <h5 class="card-title">{{ $medicine->product }}</h5>
                                        <p class="card-text text-muted small">
                                            @if($medicine->expiry_date)
                                                Expires: {{ $medicine->expiry_date->format('M Y') }}
                                            @endif
                                        </p>
                                        
                                        <!-- Debug info (remove in production) -->
                                        <small class="text-muted d-block mb-2">
                                            Image Path: {{ $medicine->image ?? 'No image set' }}
                                        </small>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <h5 class="text-purple mb-0">
                                                ${{ number_format($medicine->product->price ?? $medicine->cost_price, 2) }}
                                            </h5>
                                            @if($medicine->quantity > 0)
                                                <button class="btn btn-sm btn-purple reserve-medicine" 
                                                        data-id="{{ $medicine->id }}"
                                                        data-name="{{ $medicine->product }}"
                                                        data-price="{{ $medicine->product->price ?? $medicine->cost_price }}"
                                                        data-category="{{ $medicine->category->name ?? 'General' }}">
                                                    <i class="fas fa-bookmark me-1"></i> Reserve
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    Out of Stock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $medicines->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-4x text-muted mb-3"></i>
                            <h4>No medicines found</h4>
                            <p class="text-muted">Try adjusting your search criteria or browse all medicines.</p>
                            <a href="{{ route('medicines') }}" class="btn btn-purple">View All Medicines</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Rest of the modal code stays the same -->
    <!-- Reservation Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light-gradient">
                    <h5 class="modal-title text-purple" id="reservationModalLabel">
                        <i class="fas fa-bookmark me-2"></i> Reserve Medicine
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reservationForm">
                        @csrf
                        <!-- Medicine Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1" id="modal-medicine-name">Medicine Name</h6>
                                        <p class="text-muted mb-0">
                                            Category: <span id="modal-medicine-category">Category</span> | 
                                            Price: $<span id="modal-medicine-price">0.00</span>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Quantity:</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary" id="decrease-qty">-</button>
                                            <input type="number" class="form-control text-center" id="medicine-quantity" 
                                                   name="quantity" value="1" min="1" max="10">
                                            <button type="button" class="btn btn-outline-secondary" id="increase-qty">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pharmacy Selection -->
                        <div class="mb-3">
                            <label class="form-label">Select Pharmacy:</label>
                            <select class="form-select" name="pharmacy" required>
                                <option value="">Choose a pharmacy</option>
                                <option value="Main Street Pharmacy|123 Main St, Irbid|+962-798-030-585">
                                    Main Street Pharmacy - 123 Main St, Irbid
                                </option>
                                <option value="Central Pharmacy|456 Center Ave, Irbid|+962-798-030-585">
                                    Central Pharmacy - 456 Center Ave, Irbid
                                </option>
                                <option value="Downtown Pharmacy|789 Downtown Blvd, Irbid|+962-798-030-585">
                                    Downtown Pharmacy - 789 Downtown Blvd, Irbid
                                </option>
                            </select>
                        </div>

                        <!-- Special Instructions -->
                        <div class="mb-3">
                            <label class="form-label">Special Instructions (Optional):</label>
                            <textarea class="form-control" name="notes" rows="3" 
                                      placeholder="Any special requests or notes..."></textarea>
                        </div>

                        <!-- Order Summary -->
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-purple mb-2">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Subtotal:</span>
                                    <span id="modal-subtotal">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Tax (8%):</span>
                                    <span id="modal-tax">$0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong class="text-purple" id="modal-total">$0.00</strong>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="medicine_id" id="modal-medicine-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-purple" id="confirm-reservation">
                        <i class="fas fa-check me-1"></i> Confirm Reservation
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentMedicine = {};
        
        // Reserve medicine buttons
        const reserveButtons = document.querySelectorAll('.reserve-medicine');
        
        reserveButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Check if user is logged in
                @guest('customer')
                    // Redirect to login if not authenticated
                    window.location.href = '{{ route("customer.login") }}';
                    return;
                @endguest
                
                // Get medicine data
                currentMedicine = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    price: parseFloat(this.dataset.price),
                    category: this.dataset.category
                };
                
                // Populate modal
                document.getElementById('modal-medicine-name').textContent = currentMedicine.name;
                document.getElementById('modal-medicine-category').textContent = currentMedicine.category;
                document.getElementById('modal-medicine-price').textContent = currentMedicine.price.toFixed(2);
                document.getElementById('modal-medicine-id').value = currentMedicine.id;
                
                // Reset quantity and calculate total
                document.getElementById('medicine-quantity').value = 1;
                updateModalTotal();
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('reservationModal'));
                modal.show();
            });
        });
        
        // Quantity controls
        document.getElementById('decrease-qty').addEventListener('click', function() {
            const qtyInput = document.getElementById('medicine-quantity');
            if (qtyInput.value > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                updateModalTotal();
            }
        });
        
        document.getElementById('increase-qty').addEventListener('click', function() {
            const qtyInput = document.getElementById('medicine-quantity');
            if (qtyInput.value < 10) {
                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateModalTotal();
            }
        });
        
        document.getElementById('medicine-quantity').addEventListener('change', updateModalTotal);
        
        // Confirm reservation
        document.getElementById('confirm-reservation').addEventListener('click', function() {
            submitReservation();
        });
        
        function updateModalTotal() {
            const quantity = parseInt(document.getElementById('medicine-quantity').value);
            const subtotal = currentMedicine.price * quantity;
            const tax = subtotal * 0.08;
            const total = subtotal + tax;
            
            document.getElementById('modal-subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('modal-tax').textContent = '$' + tax.toFixed(2);
            document.getElementById('modal-total').textContent = '$' + total.toFixed(2);
        }
        
        function submitReservation() {
            const form = document.getElementById('reservationForm');
            const formData = new FormData(form);
            
            // Parse pharmacy selection
            const pharmacyData = formData.get('pharmacy').split('|');
            
            const reservationData = {
                items: [{
                    medicine_id: currentMedicine.id,
                    quantity: parseInt(formData.get('quantity'))
                }],
                pharmacy_name: pharmacyData[0],
                pharmacy_address: pharmacyData[1],
                pharmacy_phone: pharmacyData[2],
                notes: formData.get('notes'),
                _token: '{{ csrf_token() }}'
            };
            
            // Submit reservation
            fetch('{{ route("customer.reservations.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(reservationData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('reservationModal'));
                    modal.hide();
                    
                    // Show success message
                    showAlert('Reservation created successfully!', 'success');
                    
                    // Optionally redirect to reservations page
                    setTimeout(() => {
                        window.location.href = '{{ route("my-reservations") }}';
                    }, 2000);
                } else {
                    showAlert('Error creating reservation: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error creating reservation. Please try again.', 'danger');
            });
        }
        
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    });
</script>
@endsection