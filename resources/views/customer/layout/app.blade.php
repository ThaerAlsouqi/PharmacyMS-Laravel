<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediFind - @yield('title', 'Your Health, Our Priority')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-pills text-purple me-2"></i>
                <span class="fw-bold text-purple">MediFind</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="medicinesDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Medicines
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="medicinesDropdown">
                            <li><a class="dropdown-item" href="{{ route('medicines') }}">All Medicines</a></li>
                            <li><a class="dropdown-item" href="{{ route('medicines', ['categories' => ['prescription']]) }}">Prescription Medicines</a></li>
                            <li><a class="dropdown-item" href="{{ route('medicines', ['categories' => ['otc']]) }}">Over-the-Counter</a></li>
                            <li><a class="dropdown-item" href="{{ route('medicines', ['categories' => ['vitamins']]) }}">Health Supplements</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('symptom-checker') ? 'active' : '' }}" href="{{ route('symptom-checker') }}">Symptom Checker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my-reservations') ? 'active' : '' }}" href="{{ route('my-reservations') }}">My Reservations</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <form class="d-flex me-2" action="{{ route('medicines') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control search-input" type="search" name="search" 
                                   placeholder="Search medicines..." aria-label="Search" 
                                   value="{{ request('search') }}">
                            <button class="btn btn-purple" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    @guest('customer')
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-purple me-2">Login</a>
                        <a href="{{ route('customer.register') }}" class="btn btn-purple">Sign Up</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-outline-purple dropdown-toggle" type="button" id="userDropdown" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> {{ Auth::guard('customer')->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('my-reservations') }}">
                                    <i class="fas fa-clipboard-list me-2"></i> My Reservations
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}">
                                    <i class="fas fa-user-edit me-2"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3 d-flex align-items-center">
                        <i class="fas fa-pills me-2"></i> MediFind
                    </h5>
                    <p class="text-light-purple">Your trusted partner for all your medication needs.</p>
                    <div class="mt-3">
                        <div class="purple-divider"></div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-light-purple mb-3 fw-bold">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('medicines') }}" class="footer-link">Find Medicines</a></li>
                        <li class="mb-2"><a href="{{ route('symptom-checker') }}" class="footer-link">Symptom Checker</a></li>
                        <li class="mb-2"><a href="{{ route('my-reservations') }}" class="footer-link">My Reservations</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Pharmacies Near Me</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-light-purple mb-3 fw-bold">Support</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">FAQs</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="footer-link">Contact Us</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="text-light-purple mb-3 fw-bold">Connect With Us</h5>
                    <div class="d-flex mb-3">
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
                    <p class="text-light-purple mb-2">Subscribe to our newsletter</p>
                    <div class="input-group">
                        <input type="email" class="form-control bg-transparent text-white" placeholder="Your email">
                        <button class="btn btn-light-purple" type="button">Send</button>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="text-light-purple mb-0">© {{ date('Y') }} MediFind. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>