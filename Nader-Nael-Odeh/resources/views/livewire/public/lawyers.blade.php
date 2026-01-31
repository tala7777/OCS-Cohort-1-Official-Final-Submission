<div>
    <section class="hero-section text-center pt-5 mt-5 bg-dark">
        <div class="container mt-5">
            <h1 class="display-4 fw-bold mb-4">Find the Right <span class="text-warning">Legal Expert</span></h1>
            <p class="lead text-muted mb-5">Verified professionals specialized in over 15 areas of law.</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group input-group-lg shadow-lg border border-secondary rounded-pill overflow-hidden bg-primary-navy">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-4"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control bg-primary-navy border-0 py-3 text-white" placeholder="Search lawyer by name..." wire:model.live="search">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4">
                <div class="card p-4 shadow-sm border-secondary sticky-top" style="top: 100px; z-index: 1;">
                    <h6 class="fw-bold mb-3"><i class="fas fa-filter text-warning me-2"></i> Filter Lawyers</h6>
                    
                    <div class="mb-3">
                        <label class="small text-muted mb-2">Specialization</label>
                        <select class="form-select border-secondary bg-primary-navy" wire:model.live="categoryFilter">
                            <option value="">All Specializations</option>
                           @foreach ($categories as $category)
                           <option value="{{ $category->id }}">{{ $category->name }}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        
                    </div>
                </div>
            </div>

            <!-- Lawyers Grid -->
            <div class="col-lg-9">
                <div id="lawyers-grid" class="row">
                    @forelse ($lawyers as $lawyer)
                    <div class="col-md-4 mb-4" wire:key="lawyer-{{ $lawyer->id }}">
                        <div class="card h-100 border-secondary p-4 text-center card-hover overflow-hidden d-flex flex-column">
                            @if($lawyer->profile_photo_path)
                                <img src="{{ Str::startsWith($lawyer->profile_photo_path, 'http') ? $lawyer->profile_photo_path : asset('storage/' . $lawyer->profile_photo_path) }}" class="rounded-circle mx-auto mb-3 border border-secondary p-1 object-fit-cover" width="100" height="100">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($lawyer->user->name) }}&background=0d6efd&color=fff&size=100" class="rounded-circle mx-auto mb-3 border border-secondary p-1" width="100">
                            @endif

                            <h5 class="fw-bold mb-1">Atty. {{ $lawyer->user->name }}</h5>
                            <div class="mb-3">
                                @foreach ($lawyer->categories->take(2) as $category) 
                                    <span class="badge bg-secondary badge-outline rounded-pill mb-1">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            
                            <p class="text-muted small mb-4 text-truncate-3">{{ Str::limit($lawyer->bio, 80) }}</p>
                            
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <span class="small text-muted text-decoration-none"><i class="fas fa-comment-dots text-primary me-1"></i>{{ $lawyer->user->replies->count() }} Answers</span>
                            </div>
                            <a href="{{ url('/lawyer-profile/'.$lawyer->user->id) }}" class="btn btn-primary w-100 rounded-pill fw-bold mt-auto">View Profile</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                       <div class="py-5">
                            <i class="fas fa-user-tie fa-4x text-muted mb-3 opacity-50"></i>
                            <h3 class="text-white-50">No lawyers found</h3>
                            <p class="text-muted">Try adjusting your search or filter criteria.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination Footer -->
                <div class="px-4 py-3 border-top border-secondary d-flex align-items-center justify-content-between mt-4">
                    <div class="text-muted small">
                        Showing {{ $lawyers->firstItem() ?? 0 }} to {{ $lawyers->lastItem() ?? 0 }} of {{ $lawyers->total() }} results
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if ($lawyers->onFirstPage())
                            <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @else
                            <button wire:click="previousPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @endif

                        <span class="text-muted small mx-2">
                            Page {{ $lawyers->currentPage() }} of {{ $lawyers->lastPage() }}
                        </span>

                        @if ($lawyers->hasMorePages())
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
    </div>
</div>
