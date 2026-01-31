<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Code Academy</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    
    <!-- Place your custom background styles here if you don't want to edit the CSS file -->
    <style>
   
    </style>
</head>
<body>
   <div class="background-container">
    <img src="{{ asset('assets/images/img1.png') }}" alt="Background" class="background-image">
</div>
    
    <!-- Login Wrapper -->
    <div class="login-wrapper">
        <div class="login-container">
            
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h1>Code Learn</h1>
                <p>Login to access your account</p>
            </div>
            
            <!-- Session Messages -->
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <!-- Login Form -->
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email"
                        name="email"
                        class="form-input @error('email') error @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="password-input">
                        <input 
                            type="password" 
                            id="password"
                            name="password"
                            class="form-input @error('password') error @enderror"
                            placeholder="Enter your password"
                            required
                        >
                     
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot Password?
                        </a>
                    @endif
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                
                <!-- Social Login (Optional) -->
                <div class="social-login">
                    <p>Or continue with</p>
                    <div class="social-icons">
                        <a href="#" class="social-btn google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-btn github">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-btn microsoft">
                            <i class="fab fa-microsoft"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Register Link -->
                <div class="register-link">
                    Don't have an account? 
                    <a href="{{ route('register') }}">Create new account</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Add focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
    
</body>
</html>