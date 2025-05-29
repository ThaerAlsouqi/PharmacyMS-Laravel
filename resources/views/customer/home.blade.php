@extends('customer.layout.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                        <span class="dot me-2"></span>
                        Your trusted health partner
                    </div>
                    <h1 class="display-4 fw-bold text-gradient mb-3">Your Health, Our Priority</h1>
                    <p class="lead text-secondary mb-4">
                        Find and reserve medications from local pharmacies with ease. Get what you need, when you need it.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="#medicine-search" class="btn btn-purple btn-lg shadow-purple">
                            Find Medicines <i class="fas fa-search ms-2"></i>
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-purple btn-lg">
                            How It Works <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <div class="hero-image-glow"></div>
                        <img src="/homepic.jpg" alt="Pharmacy Services" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Medicine Search Section -->
    <section class="py-5" id="medicine-search">
        <div class="container">
            <div class="text-center mb-5">
                <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                    <i class="fas fa-search me-2"></i>
                    Find what you need
                </div>
                <h2 class="display-5 fw-bold text-gradient mb-3">Find and Reserve Medicines</h2>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    Search our extensive database of medications and reserve them from your local pharmacy.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <ul class="nav nav-pills mb-4 justify-content-center" id="medicineTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search-tab-pane" 
                                    type="button" role="tab" aria-controls="search-tab-pane" aria-selected="true">
                                Search by Name
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular-tab-pane" 
                                    type="button" role="tab" aria-controls="popular-tab-pane" aria-selected="false">
                                Popular Medicines
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="medicineTabContent">
                        <div class="tab-pane fade show active" id="search-tab-pane" role="tabpanel" aria-labelledby="search-tab" tabindex="0">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="fas fa-search text-purple"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" placeholder="Enter medicine name...">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="fas fa-map-marker-alt text-purple"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" placeholder="Your location">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-purple w-100">
                                                Search Medicines
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-purple w-100">
                                                <i class="fas fa-filter me-2"></i> Advanced Filters
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="popular-tab-pane" role="tabpanel" aria-labelledby="popular-tab" tabindex="0">
                            <div class="row row-cols-2 row-cols-md-4 g-4">
                                @foreach($popularMedicines as $medicine)
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm hover-card">
                                        <div class="card-body text-center p-4">
                                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                                <img src="{{ asset($medicine['image']) }}" alt="{{ $medicine['name'] }}" class="img-fluid" style="width: 64px; height: 64px;">
                                            </div>
                                            <h5 class="card-title">{{ $medicine['name'] }}</h5>
                                            <p class="card-text text-muted">{{ $medicine['category'] }}</p>
                                            <a href="#" class="text-purple text-decoration-none">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-4">
                                <a href="#" class="btn btn-outline-purple">View All Medicines</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light-gradient" id="how-it-works">
        <div class="container">
            <div class="text-center mb-5">
                <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                    <span class="dot me-2"></span>
                    Simple Process
                </div>
                <h2 class="display-5 fw-bold text-gradient mb-3">How It Works</h2>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    Finding and reserving your medicines is simple and convenient
                </p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-search fa-2x text-purple"></i>
                            </div>
                            <h4 class="card-title text-purple">Search for Medicines</h4>
                            <p class="card-text">Enter the name of the medicine you need or use our symptom checker to find appropriate medications.</p>
                            <div class="step-number">1</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-map-marker-alt fa-2x text-purple"></i>
                            </div>
                            <h4 class="card-title text-purple">Find Nearby Pharmacies</h4>
                            <p class="card-text">We'll show you pharmacies near your location that have your medicine in stock.</p>
                            <div class="step-number">2</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-shopping-cart fa-2x text-purple"></i>
                            </div>
                            <h4 class="card-title text-purple">Reserve Your Medicine</h4>
                            <p class="card-text">Reserve your medicine online and pick it up at your convenience from the pharmacy.</p>
                            <div class="step-number">3</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-check-circle fa-2x text-purple"></i>
                            </div>
                            <h4 class="card-title text-purple">Pick Up & Pay</h4>
                            <p class="card-text">Visit the pharmacy, show your reservation code, and pay for your medicine.</p>
                            <div class="step-number">4</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Symptom Checker Section -->
    <section class="py-5" id="symptom-checker">
        <div class="container">
            <div class="text-center mb-5">
                <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                    <i class="fas fa-stethoscope fa-2x text-purple"></i>
                </div>
                <h2 class="display-5 fw-bold text-gradient mb-3">Symptom Checker</h2>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    Enter your symptoms and we'll suggest possible medications to help you feel better
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light-gradient border-0 rounded-top">
                            <h4 class="text-purple mb-0">Find Medications Based on Your Symptoms</h4>
                            <p class="text-muted mb-0 small">
                                This tool provides suggestions only and is not a substitute for professional medical advice.
                            </p>
                        </div>
                        <div class="card-body p-4">
                            <form id="symptomForm">
                                <div class="mb-4">
                                    <h5 class="text-purple mb-3">Select Your Symptoms</h5>
                                    <div class="row row-cols-1 row-cols-md-3 g-3">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Headache" id="symptom1">
                                                <label class="form-check-label" for="symptom1">Headache</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Fever" id="symptom2">
                                                <label class="form-check-label" for="symptom2">Fever</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Cough" id="symptom3">
                                                <label class="form-check-label" for="symptom3">Cough</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Sore Throat" id="symptom4">
                                                <label class="form-check-label" for="symptom4">Sore Throat</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Runny Nose" id="symptom5">
                                                <label class="form-check-label" for="symptom5">Runny Nose</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Body Aches" id="symptom6">
                                                <label class="form-check-label" for="symptom6">Body Aches</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h5 class="text-purple mb-3">How long have you had these symptoms?</h5>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="duration" id="duration1" value="less-than-day">
                                        <label class="form-check-label" for="duration1">Less than a day</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="duration" id="duration2" value="1-3-days">
                                        <label class="form-check-label" for="duration2">1-3 days</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="duration" id="duration3" value="4-7-days">
                                        <label class="form-check-label" for="duration3">4-7 days</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="duration" id="duration4" value="more-than-week">
                                        <label class="form-check-label" for="duration4">More than a week</label>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h5 class="text-purple mb-3">Additional Information</h5>
                                    <textarea class="form-control" rows="4" placeholder="Please provide any additional details about your symptoms..."></textarea>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-purple shadow-purple">
                                        Get Recommendations
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Simple form handling for demo purposes
    document.getElementById('symptomForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('In a real application, this would process your symptoms and show medication recommendations.');
    });
</script>
@endsection
