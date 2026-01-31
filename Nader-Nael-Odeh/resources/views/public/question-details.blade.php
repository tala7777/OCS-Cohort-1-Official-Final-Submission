@extends('layouts.public')

@section('title', 'Question Details - Legal Q&A')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
@endsection

@section('content')
    <div class="container py-5" style="margin-top: 60px;">
        <div class="row">
            <div class="col-lg-8">
                <!-- Question Section -->
                <!-- BACKEND: GET /api/questions/{id} -->
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-secondary">{{$question->category->name}}</span>
                            <span class="text-muted small">Asked on {{$question->created_at->diffForHumans()}}</span>
                        </div>
                        <h2 class="mb-3">{{$question->title}}</h2>
                        <p class="text-secondary mb-4">
                            {{$question->description}}
                        </p>
                        <div class="d-flex align-items-center pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <img src="https://ui-avatars.com/api/?name={{$question->owner->name}}&background=2563eb&color=fff" class="rounded-circle me-3" width="40">
                            <div>
                                <p class="mb-0 fw-semibold">{{$question->owner->name}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Answers Header -->
                <h4 class="mb-3"><i class="fas fa-comments me-2" style="color: var(--primary);"></i>Answers ({{ $question->replies->count() }})</h4>

             
                @foreach ($question->replies as $reply)
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{$reply->lawyer->name}}&background=10b981&color=fff" class="rounded-circle me-3" width="40">
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold">{{$reply->lawyer->name}}</p>
                                <small class="text-muted">@foreach($reply->lawyer->specializations as $category){{$category->name}} @endforeach</small>
                            </div>
                            <span class="badge badge-success">Verified Lawyer</span>
                        </div>
                        <p class="text-secondary mb-3">
                            {{$reply->body}}
                        </p>
                        <div class="d-flex gap-2">
                            <form action="{{ route('replies.like', $reply->id) }}" method="POST">
    @csrf
                            <button class="btn btn-sm btn-outline-primary"  >
                                <i class="far fa-thumbs-up me-1"></i>Helpful ({{$reply->likedByUsers()->count()}})
                            </button>
                            </form>
                            <small class="text-muted align-self-center">Answered on {{$reply->created_at->diffForHumans()}}</small>
                        </div>
                    </div>
                </div>
                @endforeach

            
           

                <!-- Success/Error Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @auth
                    @if(Auth::user()->role === 'lawyer' && Auth::user()->lawyerProfile?->status === 'accepted' && $question->replies->where('lawyer_id', Auth::id())->count() === 0)
                        <div id="answerFormSection">
                            <h5 class="mb-3">Your Answer</h5>
                            <div class="card mb-4 shadow-sm border-0">
                                <div class="card-body p-4">
                                    <form id="answerForm" action="{{ route('answer.store', $question->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Provide your professional answer</label>
                                            <textarea class="form-control bg-light" rows="6" name="answer" placeholder="Share your legal expertise..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                            <i class="fas fa-paper-plane"></i> Post Answer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->role === 'lawyer' && Auth::user()->lawyerProfile?->status === 'pending')
                        <div class="alert alert-info border-0 shadow-sm mb-4">
                            <i class="fas fa-clock me-2"></i> Your lawyer registration is still pending approval. You will be able to answer once verified.
                        </div>
                    @endif
                @endauth

                @guest
                    <!-- CTA for Non-Lawyers -->
                    <div id="answerCTA" class="card text-center mb-4" style="border: 2px dashed var(--border-color); background: rgba(255,255,255,0.5);">
                        <div class="card-body p-5">
                            <i class="fas fa-gavel mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
                            <h5 class="mb-2">Are you a legal professional?</h5>
                            <p class="text-muted mb-4">Share your expertise and help answer this question by joining our community of legal experts.</p>
                            <a href="{{ route('lawyer-request') }}" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-user-check me-2"></i>Become a Verified Lawyer
                            </a>
                        </div>
                    </div>
                @endguest
                
                @auth
                    @if(Auth::user()->role === 'user')
                    <div class="card text-center mb-4" style="border: 2px dashed var(--border-color);">
                        <div class="card-body p-4">
                            <p class="text-muted mb-0">Only verified lawyers can provide legal answers to questions.</p>
                        </div>
                    </div>
                    @endif
                @endauth
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Top Answerer -->
               @if($topAnswerer)
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Top Answerer</h6>
                        <div class="text-center mb-3">

                            <img src="https://ui-avatars.com/api/?name={{$topAnswerer->name}}&background=10b981&color=fff" class="rounded-circle mb-2" width="60">
                            <h6 class="mb-1">{{$topAnswerer->name}}</h6>
                            <p class="small text-muted mb-0">
                                @foreach($topAnswerer->specializations->take(2) as $spec)
                                    {{ $spec->name }}@if(!$loop->last) & @endif
                                @endforeach
                            </p>
                             <div class="mt-2">
                                <span class="badge bg-light text-dark border"><i class="fas fa-comment-dots me-1 text-primary"></i> {{ $topAnswerer->replies_count }} Answers</span>
                            </div>
                        </div>
                        <a href="{{ route('lawyer-profile', $topAnswerer->id) }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-user me-1"></i>View Profile
                        </a>
                    </div>
                </div>
          
            @endif
                <!-- Related Questions -->
                <div class="card">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Related Questions</h6>
                        <ul class="list-unstyled mb-0">
                             @foreach ($relatedQuestions as $relatedQuestion)
                            <li class="mb-3">
                                <a href="{{ route('question-details', ['id' => $relatedQuestion->id]) }}" class="text-decoration-none" style="color: var(--text-primary);">
                                    <small class="d-block mb-1">{{$relatedQuestion->title}}</small>
                                </a>
                                <small class="text-muted">{{$relatedQuestion->replies->count()}} Answers</small>
                            </li>
                            @endforeach
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script>
        // Use shared Toast if available
        const showToast = (msg) => {
            if (typeof Toast !== 'undefined') Toast.success(msg);
            else alert(msg);
        };

        function updateAnswerSection() {
            // Wait for ui.js to possibly set the role, or default to what's in session/window
            const role = window.currentDemoRole || sessionStorage.getItem('demoRole') || 'guest';
            console.log('Question Details Role Check:', role);

            const formSection = document.getElementById('answerFormSection');
            const ctaSection = document.getElementById('answerCTA');

            if (role === 'lawyer-approved') {
                formSection.style.display = 'block';
                ctaSection.style.display = 'none';
            } else if (role === 'lawyer-pending') {
                formSection.style.display = 'none';
                ctaSection.style.display = 'none';
            } else {
                formSection.style.display = 'none';
                ctaSection.style.display = 'block';
            }
        }

        // Run on load
        document.addEventListener('DOMContentLoaded', () => {
             updateAnswerSection();

             // Listen for changes from the navbar selector
             const selector = document.getElementById('roleSelector');
             if (selector) {
                 selector.addEventListener('change', () => {
                     // small delay to let ui.js update global state if needed
                     setTimeout(updateAnswerSection, 50);
                 });
             }
        });

        // Handle answer submission - removed e.preventDefault() to allow PHP submission
        // But we can add a simple loading state
        document.getElementById('answerForm')?.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Posting...';
            btn.disabled = true;
        });

        // Like answer
        function likeAnswer(answerId) {
            showToast('Demo Mode: Like will be saved via PHP backend later.');
        }
    </script>
@endsection
