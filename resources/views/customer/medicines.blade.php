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
                    <h1 class="display-5 fw-bold text-gradient mb-2">Pharmacy Medicines</h1>
                    <p class="lead text-secondary">
                        Browse our extensive collection of prescription and over-the-counter medications.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <form action="{{ route('medicines') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search medicines..." name="search" value="{{ request('search') }}">
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
                                <!-- Categories -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Categories</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="category1" name="categories[]" value="pain-relief">
                                        <label class="form-check-label" for="category1">
                                            Pain Relief
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="category2" name="categories[]" value="antibiotics">
                                        <label class="form-check-label" for="category2">
                                            Antibiotics
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="category3" name="categories[]" value="anti-inflammatory">
                                        <label class="form-check-label" for="category3">
                                            Anti-inflammatory
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="category4" name="categories[]" value="antihistamine">
                                        <label class="form-check-label" for="category4">
                                            Antihistamine
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="category5" name="categories[]" value="vitamins">
                                        <label class="form-check-label" for="category5">
                                            Vitamins & Supplements
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="category6" name="categories[]" value="first-aid">
                                        <label class="form-check-label" for="category6">
                                            First Aid
                                        </label>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Price Range</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="me-2">$</span>
                                        <input type="number" class="form-control form-control-sm" placeholder="Min" name="min_price" min="0">
                                        <span class="mx-2">-</span>
                                        <input type="number" class="form-control form-control-sm" placeholder="Max" name="max_price" min="0">
                                    </div>
                                </div>

                                <!-- Availability -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Availability</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="availability" id="all" value="all" checked>
                                        <label class="form-check-label" for="all">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="availability" id="in-stock" value="in-stock">
                                        <label class="form-check-label" for="in-stock">
                                            In Stock
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="availability" id="prescription" value="prescription">
                                        <label class="form-check-label" for="prescription">
                                            Prescription Only
                                        </label>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="mb-4">
                                    <h6 class="text-purple mb-3">Rating</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="any-rating" value="any" checked>
                                        <label class="form-check-label" for="any-rating">
                                            Any Rating
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="4-stars" value="4">
                                        <label class="form-check-label" for="4-stars">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            & Up
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rating" id="3-stars" value="3">
                                        <label class="form-check-label" for="3-stars">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            & Up
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-purple w-100">
                                    Apply Filters
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Featured Products -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light-gradient border-0">
                            <h5 class="mb-0 text-purple">
                                <i class="fas fa-star me-2"></i> Featured Products
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="featured-product mb-3">
                                <div class="d-flex">
                                    <img src="/Vitamin C Complex.jpg" alt="Featured Medicine" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="mb-1">Vitamin C Complex</h6>
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="text-warning me-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <small class="text-muted">(128)</small>
                                        </div>
                                        <div class="text-purple fw-bold">$24.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="featured-product mb-3">
                                <div class="d-flex">
                                    <img src="/Ibuprofen 400mg.jpg" alt="Featured Medicine" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="mb-1">Ibuprofen 400mg</h6>
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="text-warning me-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <small class="text-muted">(95)</small>
                                        </div>
                                        <div class="text-purple fw-bold">$12.50</div>
                                    </div>
                                </div>
                            </div>
                            <div class="featured-product">
                                <div class="d-flex">
                                    <img src="/Allergy Relief.jpg" alt="Featured Medicine" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="mb-1">Allergy Relief</h6>
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="text-warning me-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <small class="text-muted">(210)</small>
                                        </div>
                                        <div class="text-purple fw-bold">$18.75</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medicine Listings -->
                <div class="col-lg-9">
                    <!-- View Options and Sort -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <span class="me-2">View:</span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-purple active" id="grid-view">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-purple" id="list-view">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-2">Sort by:</span>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option value="popularity">Popularity</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="rating">Rating</option>
                                <option value="newest">Newest</option>
                            </select>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <p class="text-muted mb-4">Showing 1-12 of 48 results</p>

                    <!-- Grid View (Default) -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="grid-view-container">
                        <!-- Medicine 1 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/Paracetamol-500m-Caplets-32.jpg" class="card-img-top" alt="Paracetamol">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">Pain Relief</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <small class="text-muted">(42)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Paracetamol 500mg</h5>
                                    <p class="card-text text-muted small">Effective pain relief for headaches, toothaches, and other minor aches and pains.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$9.99</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 2 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/Amoxicillin-250mg.jpg" class="card-img-top" alt="Amoxicillin">
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">Prescription</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">Antibiotics</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <small class="text-muted">(78)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Amoxicillin 250mg</h5>
                                    <p class="card-text text-muted small">Antibiotic used to treat a number of bacterial infections. Requires prescription.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$15.50</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 3 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/IBUPROFEN20200mg.jpg" class="card-img-top" alt="Ibuprofen">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">Anti-inflammatory</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <small class="text-muted">(56)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Ibuprofen 200mg</h5>
                                    <p class="card-text text-muted small">Reduces inflammation, swelling, and joint pain. Effective for menstrual cramps.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$12.25</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 4 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/Loratadine10mg.jpg" class="card-img-top" alt="Loratadine">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">Antihistamine</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <small class="text-muted">(112)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Loratadine 10mg</h5>
                                    <p class="card-text text-muted small">Non-drowsy allergy relief for sneezing, runny nose, and itchy, watery eyes.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$14.99</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 5 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/Vitamin D3 1000 IU.jpg" class="card-img-top" alt="Vitamin D">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">Vitamins</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <small class="text-muted">(89)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Vitamin D3 1000 IU</h5>
                                    <p class="card-text text-muted small">Supports bone health, immune function, and overall wellness. Essential vitamin.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$19.75</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 6 -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="position-relative">
                                    <img src="/Adhesive Bandages.jpg" class="card-img-top" alt="Bandages">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light-purple text-purple">First Aid</span>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <small class="text-muted">(34)</small>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Adhesive Bandages</h5>
                                    <p class="card-text text-muted small">Flexible fabric bandages for minor cuts and scrapes. Pack of 30 assorted sizes.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h5 class="text-purple mb-0">$7.50</h5>
                                        <button class="btn btn-sm btn-purple">
                                            <i class="fas fa-shopping-cart me-1"></i> Reserve
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- List View (Hidden by Default) -->
                    <div class="d-none" id="list-view-container">
                        <!-- Medicine 1 -->
                        <div class="card mb-3 border-0 shadow-sm hover-card">
                            <div class="row g-0">
                                <div class="col-md-3 position-relative">
                                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Paracetamol">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-light-purple text-purple">Pain Relief</span>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <small class="text-muted">(42)</small>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Paracetamol 500mg</h5>
                                        <p class="card-text">Effective pain relief for headaches, toothaches, and other minor aches and pains. Paracetamol is a widely used over-the-counter pain medication that also reduces fever.</p>
                                        <p class="card-text"><small class="text-muted">Available in packs of 16, 32, and 50 tablets</small></p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <h5 class="text-purple mb-0">$9.99</h5>
                                            <button class="btn btn-purple">
                                                <i class="fas fa-shopping-cart me-1"></i> Reserve
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 2 -->
                        <div class="card mb-3 border-0 shadow-sm hover-card">
                            <div class="row g-0">
                                <div class="col-md-3 position-relative">
                                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Amoxicillin">
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">Prescription</span>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-light-purple text-purple">Antibiotics</span>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <small class="text-muted">(78)</small>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Amoxicillin 250mg</h5>
                                        <p class="card-text">Antibiotic used to treat a number of bacterial infections. It is a first-line treatment for middle ear infections and strep throat. Requires a valid prescription from a healthcare provider.</p>
                                        <p class="card-text"><small class="text-muted">Available in capsules and oral suspension</small></p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <h5 class="text-purple mb-0">$15.50</h5>
                                            <button class="btn btn-purple">
                                                <i class="fas fa-shopping-cart me-1"></i> Reserve
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine 3 -->
                        <div class="card mb-3 border-0 shadow-sm hover-card">
                            <div class="row g-0">
                                <div class="col-md-3 position-relative">
                                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Ibuprofen">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">In Stock</span>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-light-purple text-purple">Anti-inflammatory</span>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <small class="text-muted">(56)</small>
                                            </div>
                                        </div>
                                        <h5 class="card-title">Ibuprofen 200mg</h5>
                                        <p class="card-text">Reduces inflammation, swelling, and joint pain. Effective for menstrual cramps and fever reduction. Non-steroidal anti-inflammatory drug (NSAID) that works by blocking certain natural substances in your body.</p>
                                        <p class="card-text"><small class="text-muted">Available in tablets, capsules, and liquid form</small></p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <h5 class="text-purple mb-0">$12.25</h5>
                                            <button class="btn btn-purple">
                                                <i class="fas fa-shopping-cart me-1"></i> Reserve
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const gridViewContainer = document.getElementById('grid-view-container');
        const listViewContainer = document.getElementById('list-view-container');

        // Switch to grid view
        gridViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.remove('d-none');
            listViewContainer.classList.add('d-none');
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
        });

        // Switch to list view
        listViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.add('d-none');
            listViewContainer.classList.remove('d-none');
            gridViewBtn.classList.remove('active');
            listViewBtn.classList.add('active');
        });
    });
</script>
@endsection
