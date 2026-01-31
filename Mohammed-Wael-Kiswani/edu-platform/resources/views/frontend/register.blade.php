<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CodeLearn</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://img.icons8.com/color/96/000000/code.png">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-code text-primary"></i> Code<span>Learn</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.html">Courses</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3">Already have an account?</span>
                    <a href="login.html" class="btn btn-outline-primary">Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Register Form -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold">Create Your Account</h2>
                                <p class="text-muted">Join thousands of learners worldwide</p>
                            </div>
                            
                            <form id="registerForm">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" id="fullName" placeholder="John Doe" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="password" placeholder="Create a password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            Must be at least 8 characters
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Send me updates about new courses and special offers
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="text-muted">Or sign up with</p>
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-outline-primary">
                                            <i class="fab fa-google me-2"></i> Google
                                        </button>
                                        <button type="button" class="btn btn-outline-dark">
                                            <i class="fab fa-github me-2"></i> GitHub
                                        </button>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <div class="text-center">
                                    <p class="text-muted">Already have an account? <a href="login.html" class="text-decoration-none">Sign in here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-light mb-0">&copy; 2023 CodeLearn. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-light me-3">Privacy Policy</a>
                    <a href="#" class="text-light">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    
    <!-- Additional script for register page -->
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
        
        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
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
        
        // Password validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }
        });
    </script>
</body>
</html>