<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - CodeLearn</title>
    
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
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-code text-primary"></i> Code<span>Learn</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#categories') }}">Categories</a>
                    </li>
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

    <!-- Course Details -->
    <section class="py-5">
        <div class="container">
            @if(session('success_message'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <h4 class="alert-heading">{{ session('success_message.title') }}</h4>
        <p>{{ session('success_message.body') }}</p>
        <hr>
        <p class="mb-0">You can start watching the lessons below. Enjoy learning! 📚</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

            <div class="row">
                <!-- Left Column: Course Content -->
                <div class="col-lg-8">
                    <div class="mb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/courses') }}">Courses</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ $course->category }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $course->name }}</li>
                            </ol>
                        </nav>
                        
                        <h1 class="fw-bold mb-3">{{ $course->name }}</h1>
                        
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="me-4 mb-2">
                                <span class="text-warning">
                                    @for ($i = 0; $i < floor($course->rating); $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if($course->rating - floor($course->rating) >= 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    <span class="text-dark ms-1">{{ $course->rating }}</span>
                                </span>
                                <span class="text-muted ms-2">({{ $course->ratings_count }} ratings)</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="fas fa-users text-primary me-1"></i>
                                <span>{{ $course->students_count }} students</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="fas fa-clock text-primary me-1"></i>
                                <span>{{ $course->hours }} hours</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $course->category }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <img src="{{ asset('storage/' . $course->image) }}" 
                             alt="{{ $course->name }}" class="img-fluid rounded shadow">
                    </div>

                    <!-- Instructor Info (يمكنك تعديله لديناميكي لاحقًا) -->
                    <div class="card mb-5 border-0 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title mb-4">About the Instructor</h4>
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Instructor" class="rounded-circle me-3" width="80" height="80">
                                <div>
                                    <h5 class="mb-1">{{ $course->instructor_name ?? 'Michael Johnson' }}</h5>
                                    <p class="text-muted mb-2">{{ $course->instructor_title ?? 'Senior Full-Stack Developer' }}</p>
                                    <div class="d-flex flex-wrap">
                                        <div class="me-4">
                                            <i class="fas fa-star text-warning me-1"></i>
                                            <span>{{ $course->instructor_rating ?? '4.7' }} Instructor Rating</span>
                                        </div>
                                        <div class="me-4">
                                            <i class="fas fa-users text-primary me-1"></i>
                                            <span>{{ $course->instructor_students ?? '58,921' }} Students</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-play-circle text-primary me-1"></i>
                                            <span>{{ $course->instructor_courses ?? '12' }} Courses</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3">{{ $course->instructor_bio ?? 'Michael is a senior full-stack developer with over 10 years of experience...' }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="fw-bold mb-4">Course Description</h3>
                        <p>{{ $course->description }}</p>
                    </div>

                    {{-- ===================== --}}
{{-- Course Lessons --}}
{{-- ===================== --}}
<div class="mb-5">
    <h3 class="fw-bold mb-4">Course Lessons</h3>

    @if($course->lessons->count())
        <div class="accordion" id="lessonsAccordion">

        @foreach($course->lessons as $index => $lesson)
    <div class="accordion-item mb-2">
        <h2 class="accordion-header" id="heading{{ $lesson->id }}">
            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" 
                    type="button" 
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse{{ $lesson->id }}">
                <i class="fas fa-play-circle text-primary me-2"></i>
                Lesson {{ $index + 1 }}: {{ $lesson->title }}
            </button>
        </h2>

        <div id="collapse{{ $lesson->id }}" 
             class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
             data-bs-parent="#lessonsAccordion">
            <div class="accordion-body">

                @if($lesson->description)
                    <p class="text-muted">{{ $lesson->description }}</p>
                @endif

                {{-- ✅ شرط عرض الفيديو --}}
                @if($userHasPurchased)
                    <video width="100%" controls class="rounded shadow-sm">
                        <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="alert alert-warning">
                        You need to purchase this course to watch the video.
                    </div>
                @endif

            </div>
        </div>
    </div>
@endforeach


        </div>
    @else
        <div class="alert alert-warning">
            No lessons available for this course yet.
        </div>
    @endif
</div>

                </div>
                
                <!-- Right Column -->
            <div class="col-lg-4">
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <div class="display-4 fw-bold text-primary mb-2">${{ $course->price }}</div>
                <div class="text-muted mb-4">One-time payment. Lifetime access.</div>

                {{-- تحقق إذا المستخدم اشترى الكورس --}}
                @if($userHasPurchased)
                    <div class="alert alert-success text-center">
                        You have already enrolled in this course ✅
                    </div>
                @else
                    <form method="POST" action="{{ route('stripe.checkout', $course->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-shopping-cart me-2"></i> Enroll Now
                        </button>
                    </form>
                @endif

                <p class="text-muted small">30-Day Money-Back Guarantee</p>
            </div>
        </div>
    </div>
</div>


            </div>
        </div>
    </section>

    <!-- Footer ... ابقيه كما هو بدون تعديل -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
