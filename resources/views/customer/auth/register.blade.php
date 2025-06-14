@extends('customer.layout.app')

@section('title', 'Create Account')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light-gradient border-0 text-center">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-user-plus fa-2x text-purple"></i>
                            </div>
                            <h4 class="text-purple mb-0">Create Account</h4>
                            <p class="text-muted mb-0">Join MediFind to reserve medicines</p>
                        </div>
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('customer.register') }}">
                                @csrf
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone') }}" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address (Optional)</label>
                                    <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" 
                                               name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-purple">Terms of Service</a> and 
                                        <a href="#" class="text-purple">Privacy Policy</a>
                                    </label>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-purple">
                                        <i class="fas fa-user-plus me-2"></i> Create Account
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="mb-0">Already have an account? 
                                    <a href="{{ route('customer.login') }}" class="text-purple">Login here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection