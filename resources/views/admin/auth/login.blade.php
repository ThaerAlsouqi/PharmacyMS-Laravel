@extends('admin.layouts.plain')

@push('page-css')
<style>
/* Clean Professional Login */
.main-wrapper.login-body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-wrapper .container {
    max-width: 1000px;
    width: 100%;
}

.loginbox {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    display: flex;
    overflow: hidden;
    min-height: 500px;
}

/* Left side - Image */
.loginbox > div:first-child {
    flex: 1;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.loginbox img {
    max-width: 250px;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Right side - Form */
.login-right {
    flex: 1;
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-right-wrap {
    width: 100%;
    max-width: 350px;
    margin: 0 auto;
}

/* Typography */
h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
    text-align: center;
}

.account-subtitle {
    color: #718096;
    font-size: 1rem;
    margin-bottom: 40px;
    text-align: center;
}

/* Form Groups */
.form-group {
    margin-bottom: 25px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    background: #f7fafc;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control::placeholder {
    color: #a0aec0;
}

/* Button */
.btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Links */
.text-center {
    text-align: center;
}

.forgotpass, .dont-have {
    margin: 15px 0;
}

.forgotpass a, .dont-have a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.forgotpass a:hover, .dont-have a:hover {
    color: #5a67d8;
    text-decoration: underline;
}

.dont-have {
    color: #718096;
}

/* Alert */
.alert-danger {
    background: #fed7d7;
    color: #c53030;
    padding: 12px 16px;
    border-radius: 8px;
    border-left: 4px solid #e53e3e;
    margin-bottom: 20px;
    font-size: 14px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .loginbox {
        flex-direction: column;
        margin: 20px;
    }
    
    .loginbox > div:first-child {
        padding: 30px;
    }
    
    .loginbox img {
        max-width: 200px;
    }
    
    .login-right {
        padding: 40px 30px;
    }
    
    h1 {
        font-size: 1.7rem;
    }
}

@media (max-width: 480px) {
    .loginbox {
        margin: 15px;
    }
    
    .login-right {
        padding: 30px 25px;
    }
    
    .form-control {
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .btn {
        padding: 12px;
        font-size: 15px;
    }
}
</style>
@endpush

@section('content')
<h1>Pharmacy System</h1>
<p class="account-subtitle">Welcome back! Please sign in to continue</p>

@if (session('login_error'))
    <div class="alert-danger">
        {{ session('login_error') }}
    </div>
@endif

<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="form-group">
        <input class="form-control" name="email" type="email" placeholder="Email Address" required value="{{ old('email') }}" autocomplete="email">
    </div>
    <div class="form-group">
        <input class="form-control" name="password" type="password" placeholder="Password" required autocomplete="current-password">
    </div>
    <div class="form-group">
        <button class="btn btn-success" type="submit">Login</button>
    </div>
</form>

<div class="text-center forgotpass">
    <a href="{{ route('password.request') }}">Forgot Password?</a>
</div>
<div class="text-center dont-have">
    Don't have an account? <a href="{{ route('register') }}">Register</a>
</div>
@endsection