<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pharmacy Management System - Streamline your pharmacy operations">

    <title>Pharmacy Management System | PMS</title>

    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3142/3142029.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        
        .pharmacy-hero {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.1) 100%),
                        url('https://img.freepik.com/free-vector/pharmacy-shop-drugstore-interior-with-pharmacist-stand-counter-showing-medicine-client_107791-7762.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
        }
        
        .pharmacy-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.92);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        
        .nav-blur {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.4);
        }
        
        .feature-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .icon-pulse {
            animation: pulse 2s infinite;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounceGentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .floating-icons {
            position: absolute;
            color: rgba(59, 130, 246, 0.1);
            animation: float 4s ease-in-out infinite;
        }
        
        .floating-icons:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-icons:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
        .floating-icons:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 2s; }
        .floating-icons:nth-child(4) { bottom: 20%; right: 10%; animation-delay: 3s; }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm nav-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center animate-fade-in">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="icon-pulse p-2 rounded-lg mr-2">
                            <i class="fas fa-pills text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">PMS</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-1 animate-fade-in">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-300">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 transition-all duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 transition-all duration-300 btn-glow">
                                    <i class="fas fa-user-plus mr-2"></i>Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="pharmacy-hero py-24 relative overflow-hidden">
            <!-- Floating Background Icons -->
            <div class="floating-icons">
                <i class="fas fa-pills text-6xl"></i>
            </div>
            <div class="floating-icons">
                <i class="fas fa-prescription-bottle-alt text-5xl"></i>
            </div>
            <div class="floating-icons">
                <i class="fas fa-capsules text-4xl"></i>
            </div>
            <div class="floating-icons">
                <i class="fas fa-tablets text-7xl"></i>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <div class="animate-slide-up">
                        <h1 class="text-5xl font-extrabold text-gray-900 sm:text-6xl sm:tracking-tight lg:text-7xl mb-6">
                            Pharmacy Management 
                            <span class="bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                                System
                            </span>
                        </h1>
                        <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-600 leading-relaxed">
                            Streamline your pharmacy operations with our comprehensive management solution. 
                            Built for modern pharmacies, designed for efficiency.
                        </p>
                    </div>
                    
                    <div class="mt-12 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 animate-slide-up" style="animation-delay: 0.3s;">
                        <a href="{{ route('login') }}" class="group inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-xl shadow-lg text-white bg-primary-600 hover:bg-primary-700 transition-all duration-300 btn-glow">
                            <i class="fas fa-sign-in-alt mr-3 group-hover:animate-bounce-gentle"></i> 
                            Login
                            <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('register') }}" class="group inline-flex items-center px-8 py-4 border border-primary-600 text-lg font-medium rounded-xl shadow-lg text-primary-700 bg-white hover:bg-primary-50 transition-all duration-300">
                            <i class="fas fa-user-plus mr-3 group-hover:animate-bounce-gentle"></i> 
                            Register
                        </a>
                    </div>
                    
                   
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                        Key Features
                    </h2>
                    <p class="mt-4 max-w-3xl mx-auto text-xl text-gray-500">
                        Everything you need to manage your pharmacy efficiently and effectively
                    </p>
                </div>

                <div class="mt-16 grid gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="pt-6 card-hover transition-all group">
                        <div class="feature-card rounded-2xl px-8 pb-8 h-full shadow-lg">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-capsules text-2xl"></i>
                                </div>
                                <h3 class="mt-8 text-2xl font-bold text-gray-900 text-center">Inventory Management</h3>
                                <p class="mt-5 text-base text-gray-600 leading-relaxed">
                                    Track medications, manage stock levels, and set up automatic reorder points. 
                                    Get alerts for expiring medicines and low stock items.
                                </p>
                                <div class="mt-6 space-y-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Real-time stock tracking
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Expiry date management
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Automated reordering
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="pt-6 card-hover transition-all group">
                        <div class="feature-card rounded-2xl px-8 pb-8 h-full shadow-lg">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-receipt text-2xl"></i>
                                </div>
                                <h3 class="mt-8 text-2xl font-bold text-gray-900 text-center">Sales & Billing</h3>
                                <p class="mt-5 text-base text-gray-600 leading-relaxed">
                                    Process sales quickly, generate receipts, and manage customer transactions. 
                                    Support for multiple payment methods and discount systems.
                                </p>
                                <div class="mt-6 space-y-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Quick checkout process
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Multiple payment options
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Digital receipts
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="pt-6 card-hover transition-all group">
                        <div class="feature-card rounded-2xl px-8 pb-8 h-full shadow-lg">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-chart-line text-2xl"></i>
                                </div>
                                <h3 class="mt-8 text-2xl font-bold text-gray-900 text-center">Reporting</h3>
                                <p class="mt-5 text-base text-gray-600 leading-relaxed">
                                    Generate detailed reports on sales, inventory, and financial performance. 
                                    Get insights to make informed business decisions.
                                </p>
                                <div class="mt-6 space-y-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Sales analytics
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Financial reports
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Custom dashboards
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Product</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Features</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Pricing</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Updates</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">About</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Careers</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Resources</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Documentation</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Guides</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">API Status</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Legal</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Privacy</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Terms</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white transition-all">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-base text-gray-400">
                    &copy; {{ date('Y') }} Pharmacy Management System. All rights reserved.
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-all transform hover:scale-110">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all transform hover:scale-110">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all transform hover:scale-110">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all transform hover:scale-110">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div class="mt-4 text-center text-sm text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });
    </script>
</body>
</html>