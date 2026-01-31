@extends('layouts.public')

@section('title', 'LegalQ&A - Expert Legal Advice')

@section('content')
<!-- HERO SECTION -->
<section class="position-relative text-center py-5 mt-5 d-flex align-items-center" style="min-height: 80vh; background-image: url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1920&q=80'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.85;"></div>
    <div class="container position-relative z-1 py-5">
        <span class="d-inline-flex align-items-center border border-warning text-warning px-3 py-2 rounded-pill mb-4 animate-fade-down shadow-sm" style="background: rgba(255, 193, 7, 0.1); backdrop-filter: blur(5px);">
            <i class="fas fa-star me-2"></i> 
            <span class="fw-bold text-uppercase small letter-spacing-1">Trusted by 10,000+ Users</span>
        </span>
        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-up">
            Expert Legal Advice, <br>
            <span class="text-warning">Simplified.</span>
        </h1>
        <p class="lead text-light mb-5 mx-auto animate-fade-up" style="max-width: 600px; animation-delay: 0.2s; opacity: 0.9;">
            Connect with verified lawyers, get answers to your legal questions, and read expert insights—all in one place.
        </p>
        
        <div class="d-flex justify-content-center gap-3 animate-fade-up" style="animation-delay: 0.4s;">
            @if (auth()->check() && auth()->user()->role === 'user')
                <a href="{{ route('ask-question') }}" class="btn btn-gold btn-lg rounded-pill px-5 fw-bold shadow-lg">Ask a Question</a>
            @endif
            <a href="{{ route('index') }}" class="btn btn-outline-warning btn-lg rounded-pill px-5 fw-bold hover-scale" style="border-width: 2px;">
                <i class="fas fa-list-ul me-2"></i> Browse Questions
            </a>
            <a href="{{ route('lawyers') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold hover-scale" style="border-width: 2px;">
                <i class="fas fa-user-tie me-2"></i> Find Lawyers
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mt-5 mx-auto animate-fade-up" style="max-width: 700px; animation-delay: 0.6s;">
            <form action="{{ route('index') }}" method="GET" class="position-relative">
                <input type="text" name="search" class="form-control form-control-lg rounded-pill py-3 px-5 bg-dark border-secondary text-white shadow" placeholder="Search for questions..." style="backdrop-filter: blur(10px); background: rgba(30, 41, 59, 0.8) !important; " >
                <button type="submit" class="btn btn-gold rounded-circle position-absolute top-50 end-0 translate-middle-y me-2" style="width: 45px; height: 45px;">
                    <i class="fas fa-search"></i>
                </button>
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-4 text-muted"></i>
            </form>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="py-5 bg-dark border-top border-bottom border-secondary">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <h2 class="fw-bold text-white mb-0 display-5">98%</h2>
                <p class="text-muted small text-uppercase letter-spacing-1">Satisfaction Rate</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="fw-bold text-white mb-0 display-5">24h</h2>
                <p class="text-muted small text-uppercase letter-spacing-1">Avg. Response Time</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="fw-bold text-white mb-0 display-5">500+</h2>
                <p class="text-muted small text-uppercase letter-spacing-1">Verified Lawyers</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 class="fw-bold text-white mb-0 display-5">15k+</h2>
                <p class="text-muted small text-uppercase letter-spacing-1">Questions Solved</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="py-5 bg-tertiary">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-warning fw-bold text-uppercase letter-spacing-2">How It Works</h6>
            <h2 class="fw-bold text-white">Legal help in 3 simple steps</h2>
        </div>
        
        <div class="row g-4">
            <!-- Step 1 -->
            <div class="col-md-4">
                <div class="card bg-dark border-secondary h-100 p-4 text-center card-hover position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-question fa-6x text-secondary"></i>
                    </div>
                    <div class="d-inline-flex align-items-center justify-content-center bg-soft-primary text-primary rounded-circle mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-pen-fancy fa-2x"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-3">1. Ask a Question</h4>
                    <p class="text-muted">Post your legal query anonymously. Provide details to get the most accurate advice from professionals.</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-md-4">
                <div class="card bg-dark border-secondary h-100 p-4 text-center card-hover position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-gavel fa-6x text-secondary"></i>
                    </div>
                    <div class="d-inline-flex align-items-center justify-content-center bg-soft-warning text-warning rounded-circle mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-3">2. Get Answers</h4>
                    <p class="text-muted">Verified lawyers will review your question and provide professional guidance and next steps.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-4">
                <div class="card bg-dark border-secondary h-100 p-4 text-center card-hover position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-handshake fa-6x text-secondary"></i>
                    </div>
                    <div class="d-inline-flex align-items-center justify-content-center bg-soft-success text-success rounded-circle mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-3">3. Solve Your Issue</h4>
                    <p class="text-muted">Use the advice to resolve your legal matter, or connect directly with a lawyer for representation.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-5 bg-dark border-top border-bottom border-secondary">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative">
                    <img src="{{ asset('assets/img/hero-law.jpg') }}" class="img-fluid rounded-4 shadow-lg position-relative z-1" alt="Meeting" onerror="this.src='https://placehold.co/800x600/1e293b/FFF?text=Meeting'">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gold rounded-4" style="transform: translate(-15px, -15px); z-index: 0; opacity: 0.2;"></div>
                    <div class="position-absolute bottom-0 end-0 bg-primary-navy p-4 rounded-3 shadow-lg border border-secondary" style="max-width: 200px; transform: translate(30px, 30px); z-index: 2;">
                        <h2 class="text-gold fw-bold mb-0">15+</h2>
                        <small class="text-white">Years of Combined Legal Experience</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <span class="text-primary fw-bold text-uppercase letter-spacing-1">Why Choose LegalQ&A?</span>
                <h2 class="fw-bold text-white display-5 mb-4 mt-2">Professional Advice You Can Trust</h2>
                <p class="text-muted lead mb-4">We bridge the gap between complex legal jargons and everyday clarity. Our platform ensures you get timely answers from certified professionals.</p>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-shield-alt text-primary fa-lg"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-white fw-bold mb-1">100% Confidential</h5>
                        <p class="text-muted small">Your identity and questions are kept anonymous until you choose to reveal them.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="flex-shrink-0 bg-soft-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                         <i class="fas fa-certificate text-warning fa-lg"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="text-white fw-bold mb-1">Verified Lawyers</h5>
                        <p class="text-muted small">Every lawyer on our platform undergoes a strict verification process.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RECENT QUESTIONS Preview -->
<section class="py-5 bg-dark">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase letter-spacing-2">Community</h6>
                <h2 class="fw-bold text-white">Recent Questions</h2>
            </div>
            <a href="{{ route('index') }}" class="btn btn-outline-light rounded-pill px-4">View All</a>
        </div>

        <div class="row g-4">
            @foreach($latestQuestions as $question)
            <div class="col-md-4">
                <div class="card bg-tertiary border-secondary h-100 card-hover">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge bg-soft-primary text-primary-soft">{{ $question->category->name ?? 'General' }}</span>
                            <span class="float-end text-muted small">{{ $question->created_at->diffForHumans() }}</span>
                        </div>
                        <h5 class="fw-bold text-white mb-2 text-truncate">{{ $question->title }}</h5>
                        <p class="text-muted small mb-4">{{ Str::limit($question->description, 100) }}</p>
                        <a href="{{ route('question-details', $question->id) }}" class="text-warning text-decoration-none fw-bold small stretched-link">
                            Read Discussion <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-footer bg-transparent border-secondary py-3">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="far fa-comment-alt text-muted me-2"></i>
                                <span class="text-muted small">{{ $question->replies_count ?? 0 }} Answers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-5 bg-primary-navy position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 w-50 h-100 bg-gradient-primary opacity-20" style="filter: blur(80px); transform: translate(30%, -20%);"></div>
    <div class="container py-5 position-relative z-1 text-center">
        <h2 class="display-5 fw-bold text-white mb-4">Are you a qualified Lawyer?</h2>
        <p class="lead text-white-50 mb-5 mx-auto" style="max-width: 600px;">Join our network of legal professionals, build your online reputation, and connect with potential clients.</p>
        <a href="{{ route('lawyer-request') }}" class="btn btn-gold btn-lg rounded-pill px-5 fw-bold shadow-lg hover-scale">Join as a Lawyer</a>
    </div>
</section>
@endsection
