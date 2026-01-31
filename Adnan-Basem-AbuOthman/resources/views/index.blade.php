@extends('layouts.master')


@section('title', 'Sakan - Student Housing Platform')



@section('head')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">


@endsection




@section('content')



    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container hero-content">
            <h1>Your Smart Way to Find<br>Student Housing</h1>
            <p>Find safe, affordable, and convenient apartments near your university in minutes. Connect directly with
                owners.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('apartmentspage') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-search"></i> Find an Apartment
                </a>

                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg" style="border: 2px solid white;">
                    <i class="bi bi-house-add"></i> Post Your Apartment
                </a>



            </div>
        </div>
    </header>

    <!-- About Us Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Sakan?</h2>
                <p>We make student life easier by providing the best housing solutions.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-mortarboard"></i></div>
                        <h5>University-Based Search</h5>
                        <p class="text-muted small">Find homes closest to your campus easily.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-chat-dots"></i></div>
                        <h5>Direct Contact</h5>
                        <p class="text-muted small">Connect directly with apartment owners.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-house-heart"></i></div>
                        <h5>Student Friendly</h5>
                        <p class="text-muted small">Homes designed for student needs & budgets.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="bi bi-shield-check"></i></div>
                        <h5>Secure Platform</h5>
                        <p class="text-muted small">Verified listings and safe interactions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Universities Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Explore Top Universities</h2>
                <p>Find housing near the most popular campuses.</p>
            </div>
            <div class="row g-4">


                @forelse($universities as $uni)
                    <div class="col-md-4">
                        <div class="card university-card">
                            <img src="{{ asset('storage/' . $uni->image) }}" class="card-img-top" alt="University">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $uni->name }}</h5>
                                <p class="text-muted"><i class="bi bi-geo-alt"></i>{{ $uni->location }}</p>

                                <a href="{{ route('apartmentspage', ['university_id' => $uni->id]) }}"
                                    class="btn btn-secondary w-100">
                                    View Apartments
                                </a>
                            </div>
                        </div>
                    </div>



                @empty

                    <div class="col-md-4">
                        <p>no universities yet</p>
                    </div>
                @endforelse



            </div>
            <div class="text-center mt-5">
                <a href="{{ route('universitiesPage') }}" class="btn btn-outline-primary">View All Universities</a>
            </div>
        </div>
    </section>

    <!-- Apartments Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Newest Apartment Listings</h2>
                <p>Explore the latest apartments posted just for you.</p>
            </div>
            <div class="row g-4">


                @forelse($apartments as $apart)
                    <!-- Apartment Card 1 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card apartment-card">
                            <img src="{{ asset('storage/' . $apart->images->first()->image_path) }}" class="card-img-top"
                                alt="Apartment">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $apart->name }}</h5>

                                    @if ($apart->rentType == 'whole')
                                        <span class="apartment-price">{{ $apart->price }}<small
                                                class="text-muted text-sm fw-normal">/mo</small></span>
                                    @elseif($apart->rentType == 'rooms')
                                        <span class="apartment-price">{{ $apart->price }}<small
                                                class="text-muted text-sm fw-normal">/room</small></span>
                                    @endif




                                </div>
                                <div class="apartment-meta">
                                    <i class="bi bi-mortarboard"></i> Near {{ $apart->university->name }}
                                </div>
                                <p class="text-muted small">{{ Str::limit($apart->description) }}</p>
                                <a href="{{ route('apartments_d', $apart->id) }}" class="btn btn-primary w-100 btn-sm">View
                                    Details</a>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="col-md-3">

                        <p>no apartments yet</p>

                    </div>
                @endforelse


            </div>
            <div class="text-center mt-5">
                <a href="{{ route('apartmentspage') }}" class="btn btn-outline-primary">View All Apartments</a>
            </div>
        </div>
    </section>


@endsection



@section('js')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>


@endsection
