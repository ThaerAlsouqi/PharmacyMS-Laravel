@extends('customer.layout.app')

@section('title', 'Contact Us')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <div class="badge bg-light-purple text-purple mb-3 px-3 py-2 rounded-pill">
                    <i class="fas fa-envelope me-2"></i>
                    Get in Touch
                </div>
                <h1 class="display-5 fw-bold text-gradient mb-3">Contact Us</h1>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    Have questions or feedback? We're here to help. Reach out to our team.
                </p>
            </div>

            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="text-purple mb-4">Contact Information</h3>
                            
                            <div class="d-flex mb-4">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Our Location</h5>
                                    <p class="text-muted mb-0">123 Medical Avenue, Healthcare City, Country</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Phone Number</h5>
                                    <p class="text-muted mb-0">+962 798030585</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email Address</h5>
                                    <p class="text-muted mb-0">mohammad23altill@gmail.com</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Working Hours</h5>
                                    <p class="text-muted mb-0">Friday: closed</p>
                                    <p class="text-muted mb-0">Saturday - Thursday: 9:00 AM - 6:00 PM</p>
                                </div>
                            </div>
                            
                            <h5 class="text-purple mb-3">Follow Us</h5>
                            <div class="d-flex">
                                <a href="#" class="social-icon me-2">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-icon me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-icon me-2">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-icon">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="text-purple mb-4">Send Us a Message</h3>
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-purple shadow-purple">
                                            Send Message <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="py-5 bg-light-gradient">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="text-gradient">Find Us on the Map</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <!-- Replace with actual map implementation in production -->
                    <div class="bg-light text-center py-5" style="height: 400px;">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <i class="fas fa-map-marked-alt fa-4x text-purple mb-3"></i>
                            <p class="mb-0">Interactive map would be displayed here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
