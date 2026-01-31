<div>
     <section class="hero-section text-center pt-5 mt-5">
        <div class="container mt-5">
            <h1 class="display-4 fw-bold mb-4">Get Expert Legal Advice, <span class="text-warning">Instantly</span></h1>
            <p class="lead text-muted mb-5">Browse legal questions or ask your own to verified professionals.</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group input-group-lg shadow-lg border border-secondary rounded-pill overflow-hidden bg-primary-navy">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-4"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 py-3 text-white" placeholder="Search questions by keyword..." 
                               wire:model.live="search">
                    </div>
                </div>
            </div>
        </div>
    </section>
 <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar">
                    <div class="card p-3 shadow-sm border-secondary mb-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-filter text-warning me-2"></i> Categories</h6>
                        <select class="form-select mb-3" wire:model.live="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)

                            <option value="{{$category->id}}">{{$category->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="card p-3 shadow-sm border-secondary">
                        <h6 class="fw-bold mb-3"><i class="fas fa-sort text-warning me-2"></i> Sort By</h6>
                        <select class="form-select" wire:model.live="sort">
                            <option value="date-newest">Newest First</option>
                            <option value="date-oldest">Oldest First</option>
                            <option value="answers-most">Most Answered</option>
                        </select>
                    </div>
                    @auth
                    @if(auth()->user()->role == 'user')
                    <div class="mt-4">
                        <a href="{{ url('ask-question') }}" class="btn btn-gold w-100 rounded-pill py-3 fw-bold shadow">
                            <i class="fas fa-plus me-2"></i> Ask a Question
                        </a>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>

            <div class="col-lg-9">
                <div id="questions-container" class="row">
                    @if (session('success'))
                        <div class="col-12 mb-4">
                            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <!-- Sample Item 1 -->
                    @forelse($questions as $question)
                    <div class="col-12 mb-4" >
                        <div class="card question-card h-100 p-4 card-hover overflow-hidden">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-soft-primary text-primary-soft badge-outline px-3 py-2 rounded-pill">{{$question->category->name}}</span>
                                <span class="text-muted small"><i class="fas fa-clock me-1"></i> {{$question->created_at}}</span>
                            </div>
                            <h5 class="fw-bold mb-3"><a href="{{ url('/question-details', $question->id) }}" class="text-white text-decoration-none">{{$question->title}}</a></h5>
                            <p class="text-muted small mb-4">{{$question->description}}</p>
                            <div class="d-flex align-items-center pt-3 border-top border-secondary">
                                <div class="small"><i class="fas fa-comments text-warning me-2"></i> <span class="text-white">{{ $question->replies->count() }} Answers</span></div>
                                <a href="{{ url('/question-details/'.$question->id) }}" class="btn btn-outline-warning btn-sm rounded-pill px-4 ms-auto">Read Details</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                       <div class="py-5">
                            <i class="far fa-comments fa-4x text-muted mb-3 opacity-50"></i>
                            <h3 class="text-white-50">No questions found</h3>
                            <p class="text-muted">Try adjusting your search or category filter.</p>
                        </div>
                    </div>
                    @endforelse
                
                </div>
                
                <div class="px-4 py-3 border-top border-secondary d-flex align-items-center justify-content-between mt-4">
                    <div class="text-muted small">
                        Showing {{ $questions->firstItem() ?? 0 }} to {{ $questions->lastItem() ?? 0 }} of {{ $questions->total() }} results
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if ($questions->onFirstPage())
                            <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @else
                            <button wire:click="previousPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @endif

                        <span class="text-muted small mx-2">
                            Page {{ $questions->currentPage() }} of {{ $questions->lastPage() }}
                        </span>

                        @if ($questions->hasMorePages())
                            <button wire:click="nextPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
