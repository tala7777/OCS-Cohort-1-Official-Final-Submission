<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Code Academy</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <!-- Background Container -->
    <div class="background-container">
        <img src="{{ asset('assets/images/img1.png') }}" alt="Background" class="background-image">
    </div>
    
    <!-- Register Wrapper -->
    <div class="login-wrapper">
        <div class="login-container">
            
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>Code Academy</h1>
                <p>Create your account</p>
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
            
            <!-- Register Form -->
            <form class="login-form" method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        class="form-input @error('name') error @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
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
                            placeholder="Create a password"
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock"></i>
                        Confirm Password
                    </label>
                    <div class="password-input">
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Confirm your password"
                            required
                        >
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Register Button -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
                
                <!-- Login Link -->
                <div class="register-link">
                    Already have an account? 
                    <a href="{{ route('login') }}">Login here</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Toggle password visibility for password field
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
        
        // Toggle password visibility for confirm password field
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Add focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>