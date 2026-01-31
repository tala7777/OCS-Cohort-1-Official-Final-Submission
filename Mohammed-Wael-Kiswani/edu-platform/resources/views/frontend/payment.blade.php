<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - CodeLearn</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Optional: Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('courses') }}">Courses</a></li>
            </ul>
            <div class="d-flex align-items-center">
                @auth
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth

                @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i> Register</a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- Payment Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <!-- Course Summary -->
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="card shadow-lg h-100">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Order Summary</h4>

                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                               <img src="{{ asset('storage/' . $course->image) }}" 
     alt="{{ $course->title }}" 
     class="rounded" width="80" height="80" style="object-fit: cover;">

                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-1">{{ $course->title }}</h5>
                                <p class="text-muted small mb-2">{{ $course->category }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">${{ $course->price }}</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>${{ $course->price }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="col-lg-7">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Payment Details</h4>

                        <form method="POST" action="{{ route('payment.store', $course->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Card Holder Name</label>
                                <input type="text" class="form-control" name="card_holder" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <input type="text" class="form-control" name="card_number" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Expiry</label>
                                    <input type="text" class="form-control" name="expiry" placeholder="MM/YY" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" name="cvv" required>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100">Pay ${{ $course->price }}</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('course-details', $course->id) }}">← Back to Course</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
