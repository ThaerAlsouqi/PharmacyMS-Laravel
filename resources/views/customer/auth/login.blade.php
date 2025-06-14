@extends('customer.layout.app')

@section('title', 'Login')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light-gradient border-0 text-center">
                            <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                                <i class="fas fa-user fa-2x text-purple"></i>
                            </div>
                            <h4 class="text-purple mb-0">Welcome Back</h4>
                            <p class="text-muted mb-0">Login to your account</p>
                        </div>
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('customer.login') }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-purple">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="mb-0">Don't have an account? 
                                    <a href="{{ route('customer.register') }}" class="text-purple">Create one here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection