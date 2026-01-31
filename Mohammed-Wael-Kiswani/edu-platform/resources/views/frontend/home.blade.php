<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLearn - Online Programming Education Platform</title>
    
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
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-code text-primary"></i> Code<span>Learn</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courses') }}">Courses</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#categories') }}">Categories</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#testimonials') }}">Testimonials</a>
                </li>


                {{-- رابط البروفايل يظهر فقط للمسجل دخول --}}
                @auth
                   
                @endauth
            </ul>

            <div class="d-flex align-items-center">

                {{-- إذا المستخدم مسجل دخول --}}
                @auth
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                {{-- إذا المستخدم مش مسجل --}}
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                @endguest

            </div>
        </div>
    </div>
</nav>


    <!-- Hero Section - Enhanced Version -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-image-container">
            <div class="hero-image"></div>
        </div>
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-lg-7 col-xl-6">
                    <div class="hero-content">
                        <span class="hero-badge">🚀 Premium Learning Platform</span>
                        <h1 class="hero-title">Become a <span class="text-gradient">Professional Developer</span> in 2026</h1>
                        <p class="hero-description">Master in-demand programming skills with project-based courses taught by industry experts. From web development to data science, we provide everything you need to launch your tech career.</p>
                        
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number" id="courses-count">0</div>
                                <div class="stat-label">Interactive Courses</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" id="instructors-count">0</div>
                                <div class="stat-label">Expert Instructors</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" id="graduates-count">0</div>
                                <div class="stat-label">Successful Graduates</div>
                            </div>
                        </div>
                        
                        <div class="hero-cta">
                            <a href="{{ route('courses') }}" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="fas fa-play-circle me-2"></i> Start Learning 
                            </a>
                            <a href="#how-it-works" class="btn btn-outline-light btn-lg px-5 py-3 ms-3">
                                <i class="fas fa-info-circle me-2"></i> How It Works
                            </a>
                        </div>
                        
                        <div class="hero-features mt-4">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Certificates upon completion</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Flexible learning schedule</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>1-on-1 mentorship available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-6">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Featured Courses</h2>
                    <p class="text-muted">Start your programming journey with our most popular courses</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Course 1 -->
           <div class="row g-4">
        @foreach($courses as $course)
        <div class="col-md-6 col-lg-4">
            <div class="card course-card h-100">
                <div class="position-relative">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" 
                             class="card-img-top course-img" 
                             alt="{{ $course->name }}">
                    @endif
                    <span class="badge bg-primary category-badge">{{ $course->category }}</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $course->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">${{ $course->price }}</span>
                            <a href="{{ route('course-details', $course->id) }}" class="btn btn-primary">
                             View Details
                              </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{ route('courses') }}" class="btn btn-outline-primary btn-lg">View All Courses</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-5 bg-light" id="categories">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Course Categories</h2>
                    <p class="text-muted">Explore programming topics by category</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="fab fa-html5 fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">HTML & CSS</h5>
                            <p class="card-text text-muted">Learn to build beautiful, responsive websites with HTML5 and CSS3.</p>
                            <a href="{{ route('courses') }}" class="btn btn-outline-primary">Browse Courses</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="fab fa-php fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">PHP & Laravel</h5>
                            <p class="card-text text-muted">Master backend development with PHP and the Laravel framework.</p>
                            <a href="{{ route('courses') }}" class="btn btn-outline-success">Browse Courses</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-database fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Databases</h5>
                            <p class="card-text text-muted">Learn SQL, MySQL, database design, and optimization techniques.</p>
                            <a href="{{ route('courses') }}" class="btn btn-outline-warning">Browse Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5" id="how-it-works">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Why Choose CodeLearn?</h2>
                    <p class="text-muted">Our platform is designed to help you succeed</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-3">
                                <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Expert Instructors</h5>
                            <p class="text-muted">Learn from industry professionals with years of real-world experience.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle p-3">
                                <i class="fas fa-laptop-code fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Hands-on Projects</h5>
                            <p class="text-muted">Apply your knowledge with practical projects and build a portfolio.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-certificate fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Certification</h5>
                            <p class="text-muted">Earn certificates to showcase your skills to employers.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-info rounded-circle p-3">
                                <i class="fas fa-comments fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Community Support</h5>
                            <p class="text-muted">Join our community forums to get help and collaborate with peers.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-danger rounded-circle p-3">
                                <i class="fas fa-infinity fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Lifetime Access</h5>
                            <p class="text-muted">Get lifetime access to course materials and future updates.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary rounded-circle p-3">
                                <i class="fas fa-mobile-alt fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h5>Learn Anywhere</h5>
                            <p class="text-muted">Access courses on any device, at your own pace, from anywhere.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light" id="testimonials">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Student Testimonials</h2>
                    <p class="text-muted">See what our students say about their learning experience</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Student" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-1">Sarah Johnson</h5>
                                    <p class="text-muted mb-0">Web Developer</p>
                                </div>
                            </div>
                            <p class="card-text">"The Laravel course completely transformed my career. I went from knowing basic PHP to building complex applications in just 3 months!"</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Student" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-1">Michael Chen</h5>
                                    <p class="text-muted mb-0">Full-Stack Developer</p>
                                </div>
                            </div>
                            <p class="card-text">"The hands-on projects were the best part. I built a portfolio that helped me land my first developer job. Highly recommended!"</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/67.jpg" alt="Student" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-1">Emma Rodriguez</h5>
                                    <p class="text-muted mb-0">Frontend Developer</p>
                                </div>
                            </div>
                            <p class="card-text">"As a complete beginner, the JavaScript course was perfect for me. The instructors explain complex concepts in simple terms."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-code"></i> Code<span>Learn</span>
                    </h5>
                    <p class="text-light">Empowering aspiring developers worldwide with quality programming education since 2020.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}">Courses</a></li>
                        <li class="mb-2"><a href="#">About Us</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('courses') }}">HTML/CSS</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}">JavaScript</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}">PHP/Laravel</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}">Databases</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p class="text-light mb-3">Subscribe to get updates on new courses and special offers.</p>
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Your email">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <hr class="my-5 bg-light">
            
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
    
    <!-- Stats Counter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // الأرقام النهائية
            const finalNumbers = {
                courses: 500,
                instructors: 50,
                graduates: 10000
            };

            // عناصر DOM
            const coursesElement = document.getElementById('courses-count');
            const instructorsElement = document.getElementById('instructors-count');
            const graduatesElement = document.getElementById('graduates-count');

            // دالة للعد التصاعدي
            function animateCounter(element, finalValue, duration = 2000) {
                let start = 0;
                const increment = finalValue / (duration / 16); // 60fps
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= finalValue) {
                        // تنسيق الأرقام الكبيرة
                        if (finalValue >= 1000) {
                            element.textContent = (finalValue/1000).toFixed(finalValue >= 10000 ? 0 : 1) + 'K+';
                        } else {
                            element.textContent = finalValue + '+';
                        }
                        clearInterval(timer);
                    } else {
                        if (finalValue >= 1000 && start >= 1000) {
                            element.textContent = (start/1000).toFixed(1) + 'K+';
                        } else {
                            element.textContent = Math.floor(start) + '+';
                        }
                    }
                }, 16);
            }

            // تشغيل العد بعد تأخير بسيط
            setTimeout(() => {
                animateCounter(coursesElement, finalNumbers.courses);
                animateCounter(instructorsElement, finalNumbers.instructors);
                animateCounter(graduatesElement, finalNumbers.graduates);
            }, 500);
            
            // دالة لتغيير حالة زر الدخول/التسجيل حسب حالة المستخدم
            function updateAuthState() {
                // هذه قيمة افتراضية - يمكنك تغييرها بناءً على حالة تسجيل الدخول الفعلية
                const isLoggedIn = false; // غير هذا إلى true إذا كان المستخدم مسجل دخول
                
                const userDropdown = document.getElementById('userDropdown');
                const authButtons = document.getElementById('authButtons');
                
                if (isLoggedIn) {
                    userDropdown.classList.remove('d-none');
                    authButtons.classList.add('d-none');
                } else {
                    userDropdown.classList.add('d-none');
                    authButtons.classList.remove('d-none');
                }
            }
            
            // استدعاء الدالة عند تحميل الصفحة
            updateAuthState();
        });
    </script>
</body>
</html>