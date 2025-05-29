@extends('admin.layouts.plain')

@push('page-css')
<style>
/* Clean Professional Register */
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
    min-height: 600px;
}

/* Left side - Image */
.loginbox > div:first-child {
    flex: 1;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    flex-direction: column;
    text-align: center;
}

.loginbox img {
    max-width: 200px;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.brand-text {
    color: #667eea;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.brand-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
    max-width: 280px;
}

/* Right side - Form */
.login-right {
    flex: 1;
    padding: 50px 40px;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.account-subtitle {
    color: #718096;
    font-size: 1rem;
    margin-bottom: 35px;
    text-align: center;
}

/* Form Groups */
.form-group {
    margin-bottom: 20px;
    position: relative;
}

.form-control {
    width: 100%;
    padding: 14px 18px 14px 45px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px;
    background: #f7fafc;
    transition: all 0.3s ease;
    box-sizing: border-box;
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

/* Input Icons */
.form-group::before {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #718096;
    z-index: 2;
    transition: color 0.3s ease;
}

.form-group:nth-child(1)::before { content: '👤'; }
.form-group:nth-child(2)::before { content: '📧'; }
.form-group:nth-child(3)::before { content: '🔒'; }
.form-group:nth-child(4)::before { content: '🔐'; }

.form-group:focus-within::before {
    color: #667eea;
}

/* Password Strength */
.password-strength {
    height: 3px;
    background: #e2e8f0;
    border-radius: 2px;
    margin-top: 8px;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-weak { background: #e53e3e; }
.strength-medium { background: #ff9f43; }
.strength-strong { background: #667eea; }

.password-help {
    font-size: 12px;
    margin-top: 5px;
    color: #718096;
}

/* Validation States */
.form-control.is-valid {
    border-color: #667eea;
    background-color: rgba(102, 126, 234, 0.05);
}

.form-control.is-invalid {
    border-color: #e53e3e;
    background-color: #fff5f5;
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
    margin-top: 10px;
}

.btn-danger {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Links */
.text-center {
    text-align: center;
}

.dont-have {
    margin-top: 25px;
    color: #718096;
    font-size: 14px;
}

.dont-have a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.dont-have a:hover {
    color: #5a67d8;
    text-decoration: underline;
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
        max-width: 150px;
    }
    
    .brand-text {
        font-size: 1.3rem;
    }
    
    .login-right {
        padding: 40px 30px;
    }
    
    h1 {
        font-size: 1.7rem;
    }
    
    .form-group {
        margin-bottom: 18px;
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
        padding: 12px 16px 12px 40px;
        font-size: 14px;
    }
    
    .btn {
        padding: 12px;
        font-size: 15px;
    }
    
    .form-group::before {
        left: 14px;
        font-size: 14px;
    }
}
</style>
@endpush

@section('content')
<h1>Pharmacy System</h1>
<p class="account-subtitle">Create your sales person account</p>

<form action="{{ route('register') }}" method="POST" id="registerForm">
    @csrf
    <div class="form-group">
        <input class="form-control" name="name" type="text" value="{{ old('name') }}" placeholder="Full Name" required autocomplete="name">
    </div>
    <div class="form-group">
        <input class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email">
    </div>
    <div class="form-group">
        <input class="form-control" name="password" type="password" placeholder="Password" required id="password" autocomplete="new-password">
        <div class="password-strength">
            <div class="password-strength-bar" id="strengthBar"></div>
        </div>
        <div class="password-help" id="passwordHelp">Password must be at least 8 characters</div>
    </div>
    <div class="form-group">
        <input class="form-control" name="password_confirmation" type="password" placeholder="Confirm Password" required id="confirmPassword" autocomplete="new-password">
    </div>
    <div class="form-group mb-0">
        <button class="btn btn-danger" type="submit" id="registerBtn">
            <span>Create Account</span>
        </button>
    </div>
</form>

<div class="text-center dont-have">
    Already have an account? <a href="{{ route('login') }}">Login</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const strengthBar = document.getElementById('strengthBar');
    const passwordHelp = document.getElementById('passwordHelp');
    const registerBtn = document.getElementById('registerBtn');
    const inputs = document.querySelectorAll('.form-control');
    
    // Input interactions
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-1px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    // Password strength checker
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        updateStrengthBar(strength);
        
        if (confirmPasswordInput.value) {
            checkPasswordMatch();
        }
    });
    
    // Password confirmation checker
    confirmPasswordInput.addEventListener('input', function() {
        checkPasswordMatch();
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        registerBtn.disabled = true;
        registerBtn.innerHTML = '<span>Creating Account...</span>';
    });
    
    function checkPasswordStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        return Math.min(score, 3);
    }
    
    function updateStrengthBar(strength) {
        const widths = ['25%', '65%', '100%'];
        const classes = ['strength-weak', 'strength-medium', 'strength-strong'];
        const messages = ['Weak password', 'Medium strength', 'Strong password'];
        
        strengthBar.className = 'password-strength-bar';
        
        if (strength > 0) {
            strengthBar.classList.add(classes[strength - 1]);
            strengthBar.style.width = widths[strength - 1];
            passwordHelp.textContent = messages[strength - 1];
            passwordHelp.style.color = strength === 3 ? '#667eea' : (strength === 2 ? '#ff9f43' : '#e53e3e');
        } else {
            strengthBar.style.width = '0%';
            passwordHelp.textContent = 'Password must be at least 8 characters';
            passwordHelp.style.color = '#718096';
        }
    }
    
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword && password !== confirmPassword) {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.classList.remove('is-valid');
        } else if (confirmPassword && password === confirmPassword) {
            confirmPasswordInput.classList.add('is-valid');
            confirmPasswordInput.classList.remove('is-invalid');
        }
    }
    
    function validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        
        if (field.name === 'name') {
            isValid = value.length >= 2;
        }
        
        if (field.name === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
        }
        
        if (field.name === 'password') {
            isValid = value.length >= 8;
        }
        
        if (field.name === 'password_confirmation') {
            isValid = value === passwordInput.value && value.length >= 8;
        }
        
        if (isValid && value) {
            field.classList.add('is-valid');
            field.classList.remove('is-invalid');
        } else if (value) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
        } else {
            field.classList.remove('is-valid', 'is-invalid');
        }
        
        return isValid;
    }
    
    function validateForm() {
        let isValid = true;
        
        inputs.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        
        if (passwordInput.value !== confirmPasswordInput.value) {
            isValid = false;
        }
        
        if (checkPasswordStrength(passwordInput.value) < 1) {
            isValid = false;
        }
        
        return isValid;
    }
});
</script>
@endsection