<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - CodeLearn</title>
    
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
                        <a class="nav-link active" href="{{ route('courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#testimonials">Testimonials</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    @endguest

                    @auth
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="fw-bold mb-3">Our Courses</h1>
            <p class="lead text-muted mb-4">Choose from our wide range of programming courses designed for all skill levels</p>
            
            <!-- Search -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Search courses..." id="courseSearch">
                        <button class="btn btn-primary" type="button" onclick="filterCourses()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Category Filters -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                <button class="btn btn-outline-primary active" onclick="filterCategory('all')">All</button>
                @foreach($categories as $category)
                    <button class="btn btn-outline-primary" onclick="filterCategory('{{ $category->name }}')">{{ $category->name }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="fw-bold">All Courses</h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                            Sort by: Most Popular
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="sortCourses('popular'); return false;">Most Popular</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortCourses('newest'); return false;">Newest</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortCourses('price_low'); return false;">Price: Low to High</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortCourses('price_high'); return false;">Price: High to Low</a></li>
                            <li><a class="dropdown-item" href="#" onclick="sortCourses('rating'); return false;">Highest Rated</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row g-4" id="coursesContainer">
                @foreach($courses as $course)
                <div class="col-lg-4 col-md-6 course-item" data-category="{{ $course->category }}" 
                     data-price="{{ $course->price }}" 
                     data-rating="{{ $course->rating }}" 
                     data-students="{{ $course->students_count }}"
                     data-created="{{ $course->created_at }}">
                    <div class="card course-card h-100">
                        <div class="position-relative">
                           <img src="{{ asset('storage/' . $course->image) }}" 
                            alt="{{ $course->name }}" 
                            class="card-img-top course-img">


                            <span class="badge bg-primary category-badge">{{ $course->category }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">{{ $course->name }}</h5>
                            </div>
                            <p class="card-text text-muted">{{ $course->description }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-warning">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fas fa-star{{ $i < floor($course->rating) ? '' : '-half-alt' }}"></i>
                                        @endfor
                                        <span class="text-muted ms-1">({{ $course->rating }})</span>
                                    </span>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-users me-1"></i> {{ $course->students_count }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">${{ $course->price }}</span>
                                    <a href="{{ route('course-details', $course->id) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if ($courses->hasPages())
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    @if ($courses->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $courses->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    @for ($i = 1; $i <= $courses->lastPage(); $i++)
                        <li class="page-item {{ $i == $courses->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $courses->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($courses->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $courses->nextPageUrl() }}">Next</a>
                        </li>
                    @endif
                </ul>
            </nav>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5 bg-dark">
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
                        @foreach($categories as $category)
                        <li class="mb-2"><a href="#">{{ $category->name }}</a></li>
                        @endforeach
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
                    <p class="text-light mb-0">&copy; 2026 CodeLearn. All rights reserved.</p>
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

    <script>
        // Optional: simple category filter
        function filterCategory(cat) {
            let courses = document.querySelectorAll('.course-item');
            let buttons = document.querySelectorAll('.btn-outline-primary');
            
            courses.forEach(course => {
                if(cat === 'all' || course.dataset.category === cat){
                    course.style.display = 'block';
                } else {
                    course.style.display = 'none';
                }
            });
            
            // Update active button
            buttons.forEach(button => {
                if ((cat === 'all' && button.textContent.trim() === 'All') || 
                    button.textContent.trim() === cat) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });
        }

        function filterCourses(){
            let search = document.getElementById('courseSearch').value.toLowerCase();
            let courses = document.querySelectorAll('.course-item');
            courses.forEach(course => {
                if(course.querySelector('.card-title').innerText.toLowerCase().includes(search)){
                    course.style.display = 'block';
                } else {
                    course.style.display = 'none';
                }
            });
        }
        
        // Function to sort courses
        function sortCourses(sortBy) {
            const container = document.getElementById('coursesContainer');
            const courses = Array.from(container.querySelectorAll('.course-item'));
            
            // Update dropdown button text
            const sortTexts = {
                'popular': 'Most Popular',
                'newest': 'Newest',
                'price_low': 'Price: Low to High',
                'price_high': 'Price: High to Low',
                'rating': 'Highest Rated'
            };
            document.getElementById('sortDropdown').textContent = 'Sort by: ' + sortTexts[sortBy];
            
            // Sort courses based on the selected criteria
            courses.sort((a, b) => {
                switch(sortBy) {
                    case 'popular':
                        // Sort by number of students (descending)
                        return parseInt(b.dataset.students) - parseInt(a.dataset.students);
                        
                    case 'newest':
                        // Sort by creation date (descending)
                        return new Date(b.dataset.created) - new Date(a.dataset.created);
                        
                    case 'price_low':
                        // Sort by price (ascending)
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                        
                    case 'price_high':
                        // Sort by price (descending)
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                        
                    case 'rating':
                        // Sort by rating (descending)
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                        
                    default:
                        return 0;
                }
            });
            
            // Reorder courses in the container
            courses.forEach(course => {
                container.appendChild(course);
            });
        }
    </script>
</body>
</html>