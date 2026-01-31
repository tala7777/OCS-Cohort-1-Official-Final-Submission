@extends('layouts.public')

@section('title', 'Search Results - LegalQ&A')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="text-white fw-bold"><i class="fas fa-search me-2 text-primary"></i> Search Results</h2>
            <p class="text-muted">Showing results for "<span class="text-white fst-italic">{{   $search ?? '...' }}</span>"</p>
        </div>
    </div>

    <!-- Search Tabs -->
    <ul class="nav nav-tabs border-bottom border-secondary mb-4" id="searchTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active bg-transparent text-light border-0 border-bottom border-primary border-3 rounded-0 px-4 py-3" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions" type="button" role="tab" aria-selected="true">
                <i class="fas fa-question-circle me-2"></i>Questions 
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill">{{ $questions->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link bg-transparent text-muted border-0 border-bottom border-transparent border-3 rounded-0 px-4 py-3 hover-text-light" id="lawyers-tab" data-bs-toggle="tab" data-bs-target="#lawyers" type="button" role="tab" aria-selected="false">
                <i class="fas fa-gavel me-2"></i>Lawyers
                <span class="badge bg-secondary-subtle text-secondary ms-2 rounded-pill">{{ $lawyers->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link bg-transparent text-muted border-0 border-bottom border-transparent border-3 rounded-0 px-4 py-3 hover-text-light" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-selected="false">
                <i class="fas fa-newspaper me-2"></i>Articles
                <span class="badge bg-secondary-subtle text-secondary ms-2 rounded-pill">{{ $articles->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="searchTabsContent">
        <!-- Questions Tab -->
        <div class="tab-pane fade show active" id="questions" role="tabpanel" tabindex="0">
            @if(isset($questions) && $questions->count() > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($questions as $question)
                        <div class="card bg-dark border-secondary hover-shadow-primary transition-all">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        <a href="{{ route('question-details', $question->id) }}" class="text-white text-decoration-none hover-text-primary stretched-link">
                                            {{ $question->title }}
                                        </a>
                                    </h5>
                                    <span class="badge bg-dark border border-secondary text-muted">{{ $question->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="card-text text-white-50 text-truncate">{{ Str::limit($question->content, 150) }}</p>
                                <div class="d-flex align-items-center gap-3 mt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{  'https://ui-avatars.com/api/?name='.urlencode($question->owner?->name) ?? 'unknown user' }}" class="rounded-circle" width="24" height="24" alt="User">
                                        <span class="text-muted small">{{ $question->owner?->name ?? 'unknown user' }}</span>
                                    </div>
                                    <div class="vr bg-secondary"></div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $question->category->name ?? 'General' }}</span>
                                    <div class="ms-auto text-muted small">
                                        <i class="fas fa-comment-alt me-1"></i> {{ $question->replies_count ?? 0 }} answers
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5 text-muted">
                    <div class="mb-3 display-4 opacity-25"><i class="fas fa-search"></i></div>
                    <h5>No questions found matching your search.</h5>
                    <p class="small">Try different keywords or browse categories.</p>
                </div>
            @endif
        </div>
        
        <!-- Lawyers Tab -->
        <div class="tab-pane fade" id="lawyers" role="tabpanel" tabindex="0">
            @if(isset($lawyers) && $lawyers->count() > 0)
                <div class="row g-4">
                    @foreach($lawyers as $lawyer)
                        <div class="col-md-6 col-lg-4">
                            <div class="card bg-dark border-secondary h-100 hover-transform-up transition-all">
                                <div class="card-body text-center p-4">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ $lawyer->profile_photo_path ? (Str::startsWith($lawyer->profile_photo_path, 'http') ? $lawyer->profile_photo_path : asset('storage/'.$lawyer->profile_photo_path)) : 'https://ui-avatars.com/api/?name='.urlencode($lawyer->user->name) }}" class="rounded-circle border border-2 border-primary p-1 object-fit-cover" width="96" height="96" alt="Lawyer">
                                      
                                    </div>
                                    <h5 class="card-title text-white mb-1">{{ $lawyer->user->name }}</h5>
                                    <p class="text-primary small mb-3">@foreach($lawyer->categories as $category){{ $category->name }} @if(!$loop->last), @endif @endforeach</p>
                                    
                                   

                                    <a href="{{ route('lawyer-profile', $lawyer->user->id) }}" class="btn btn-outline-primary w-100">View Profile</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                 <!-- Empty State -->
                 <div class="text-center py-5 text-muted">
                    <div class="mb-3 display-4 opacity-25"><i class="fas fa-user-tie"></i></div>
                    <h5>No lawyers found.</h5>
                </div>
            @endif
        </div>

        <!-- Articles Tab -->
        <div class="tab-pane fade" id="articles" role="tabpanel" tabindex="0">
            @if(isset($articles) && $articles->count() > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($articles as $article)
                        <div class="card bg-dark border-secondary overflow-hidden hover-shadow-primary transition-all">
                            <div class="row g-0">
                                <div class="col-md-3 position-relative">
                                    @if($article->image)
                                        <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/'.$article->image) }}" class="img-fluid h-100 object-fit-cover position-absolute" alt="Article">
                                    @else
                                        <div class="bg-secondary bg-opacity-10 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="fas fa-image fa-3x opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $article->category->name ?? 'Legal' }}</span>
                                            <small class="text-muted">{{ $article->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <h5 class="card-title"><a href="{{ route('article.details', $article->id) }}" class="text-white text-decoration-none hover-text-primary">{{ $article->title }}</a></h5>
                                        <p class="card-text text-white-50">{{ Str::limit($article->excerpt, 120) }}</p>
                                        <div class="d-flex align-items-center gap-2 mt-3">
                                            <img src="{{ $article->author->lawyerProfile->profile_photo_path ? (Str::startsWith($article->author->lawyerProfile->profile_photo_path, 'http') ? $article->author->lawyerProfile->profile_photo_path : asset('storage/'.$article->author->lawyerProfile->profile_photo_path)) : 'https://ui-avatars.com/api/?name='.urlencode($article->author->name) }}" class="rounded-circle" width="20" height="20" alt="Author">
                                            <span class="text-muted small">By {{ $article->author->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5 text-muted">
                    <div class="mb-3 display-4 opacity-25"><i class="fas fa-newspaper"></i></div>
                    <h5>No articles found.</h5>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom Tab Styling */
    .nav-tabs .nav-link {
        transition: all 0.2s ease;
    }
    .nav-tabs .nav-link:hover:not(.active) {
        border-color: transparent transparent rgba(255,255,255,0.1);
        color: #fff !important;
    }
    .hover-text-primary:hover {
        color: var(--bs-primary) !important;
    }
    .hover-shadow-primary:hover {
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.15);
        border-color: var(--bs-primary) !important;
    }
    .hover-transform-up:hover {
        transform: translateY(-5px);
        border-color: var(--bs-primary) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Simple script to handle tab styling if needed, mainly Bootstrap handles this.
    // Ensure active tab has white text, others muted.
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', event => {
            event.target.classList.remove('text-muted');
            event.target.classList.add('text-light', 'border-primary');
            
            event.relatedTarget.classList.add('text-muted');
            event.relatedTarget.classList.remove('text-light', 'border-primary');
            event.relatedTarget.classList.add('border-transparent');
        })
    });
</script>
@endsection
