@extends('layouts.public')

@section('title', 'Lawyer Profile - LegalQ&A')

@section('styles')
    <style>
        .profile-header { background: linear-gradient(135deg, var(--bg-tertiary) 0%, var(--bg-secondary) 100%); }
        .nav-tabs .nav-link { color: var(--text-muted); border: none; border-bottom: 2px solid transparent; }
        .nav-tabs .nav-link:hover { color: var(--text-primary); }
        .nav-tabs .nav-link.active { background: transparent; color: var(--primary); border-bottom: 2px solid var(--primary); font-weight: bold; }
    </style>
@endsection

@section('content')
    <!-- PROFILE HEADER -->
    <div class="container mt-5 pt-5">
        <div class="card bg-dark border-secondary shadow-lg mt-4 text-white">
            <div class="card-body p-4 p-lg-5">
                <div class="row">
                    <!-- Profile Image -->
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto position-relative overflow-hidden" style="width: 150px; height: 150px; border: 4px solid var(--primary);">
                             @if($lawyer->profile_photo_path)
                                <img src="{{ Str::startsWith($lawyer->profile_photo_path, 'http') ? $lawyer->profile_photo_path : asset('storage/' . $lawyer->profile_photo_path) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($lawyer->user->name) }}&background=0d6efd&color=fff&size=150" class="w-100 h-100" style="object-fit: cover;">
                            @endif
                        </div>
                         <!-- Edit Button (Lawyer Only) -- Auth check needed -->
                         @auth
                            @if(auth()->id() == $lawyer->user_id)
                            <div class="mt-3">
                                <a href="{{ route('lawyer.profile.edit') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    <i class="fas fa-edit me-1"></i> Edit Profile
                                </a>
                            </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Main Info -->
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="fw-bold mb-1" id="profileName">{{ $lawyer->user->name }}</h1>
                                <p class="text-primary fs-5 mb-3" id="profileSpecialization">
                                    @foreach ($lawyer->categories as $category)
                                       {{ $category->name }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                                <div class="d-flex gap-2 ms-0 mb-4">
                                     <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified</span>
                                     <span class="badge border border-secondary text-muted">{{ $lawyer->license_number ?? 'Licensed Lawyer' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-4 text-muted small mt-2" id="contactDisplay">
                             <div class="d-flex align-items-center"><i class="fas fa-envelope me-2 text-primary"></i> {{ $lawyer->user->email }}</div>
                             
                             @if($lawyer->phone)
                                <div class="d-flex align-items-center"><i class="fas fa-phone me-2 text-primary"></i> {{ $lawyer->phone }}</div>
                             @endif

                             @if($lawyer->whatsapp_number)
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-whatsapp me-2 text-success"></i> 
                                    <a href="https://wa.me/{{ $lawyer->whatsapp_number }}" target="_blank" class="text-decoration-none text-muted hover-text-white">WhatsApp</a>
                                </div>
                             @endif

                             @if($lawyer->linkedin_profile)
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-linkedin me-2 text-info"></i> 
                                    <a href="{{ $lawyer->linkedin_profile }}" target="_blank" class="text-decoration-none text-muted hover-text-white">LinkedIn Profile</a>
                                </div>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABS NAVIGATION -->
        <ul class="nav nav-tabs mt-5 border-secondary" id="profileTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active py-3 px-4" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 px-4" id="answers-tab" data-bs-toggle="tab" data-bs-target="#answers" type="button" role="tab">Answers ({{ $lawyer->user->replies->count() }})</button>
            </li>
            <li class="nav-item">
                <button class="nav-link py-3 px-4" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab">Articles ({{ $lawyer->user->articles->count() }})</button>
            </li>
        </ul>

        <!-- TABS CONTENT -->
        <div class="tab-content py-4" id="profileTabsContent">

            <!-- OVERVIEW TAB -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card bg-dark border-secondary mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3 text-warning"><i class="fas fa-user me-2"></i>About</h5>
                                <p class="text-muted" id="profileBio">
                                    {{ $lawyer->bio }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-dark border-secondary h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-white mb-2"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Location</h6>
                                        <p class="text-muted mb-0">{{ $lawyer->location ?? 'Jordan' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-dark border-secondary h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-white mb-2"><i class="fas fa-university me-2 text-info"></i>Status</h6>
                                        <p class="text-muted mb-0">{{ ucfirst($lawyer->status) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ANSWERS TAB -->
            <div class="tab-pane fade" id="answers" role="tabpanel">
                <div class="d-flex flex-column gap-3">
                    @forelse($lawyer->user->replies as $reply)
                        @if($reply->question)
                        <div class="card bg-dark border-secondary card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-secondary text-info">{{ $reply->question->category->name ?? 'General' }}</span>
                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="card-title"><a href="{{ route('question-details', $reply->question->id) }}" class="text-white text-decoration-none hover-primary">{{ $reply->question->title }}</a></h5>
                                <p class="card-text text-muted mb-0">{{ Str::limit($reply->body, 150) }}</p>
                            </div>
                        </div>
                        @endif
                    @empty
                        <p class="text-muted">No answers yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- ARTICLES TAB -->
            <div class="tab-pane fade" id="articles" role="tabpanel">
                <div class="row g-4">
                    @forelse($lawyer->user->articles as $article)
                    <div class="col-md-6">
                        <div class="card bg-dark border-secondary h-100 card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary">{{ $article->category->name ?? 'Legal' }}</span>
                                    <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="card-title"><a href="{{ route('article.details', $article->id) }}" class="text-white text-decoration-none hover-primary">{{ $article->title }}</a></h5>
                                <p class="card-text text-muted small">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12"><p class="text-muted">No articles published yet.</p></div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
