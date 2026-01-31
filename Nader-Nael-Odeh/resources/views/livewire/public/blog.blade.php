<div>
    <div class="container py-5 mt-5 pt-5">
        <!-- Search & Filter Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <!-- Minimal Search Bar -->
                <div class="position-relative mb-5" style="z-index: 10;">
                    <div class="search-matte p-1 rounded-pill d-flex align-items-center position-relative transition-all">
                        <span class="ps-3 pe-2 text-warning opacity-75">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control bg-transparent border-0 text-white shadow-none placeholder-white-50" 
                               placeholder="Search articles..." 
                               wire:model.live="search"
                               style="font-size: 1rem; height: 3rem;">
                               
                        @if($search)
                            <button class="btn btn-link text-white-50 text-decoration-none pe-3" wire:click="$set('search', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="d-flex justify-content-center gap-2 flex-wrap pb-4 border-bottom border-dark-subtle">
                    <button class="btn {{ $categoryFilter === '' ? 'btn-gold' : 'btn-matte-outline' }} btn-sm rounded-pill px-3" wire:click="$set('categoryFilter', '')">All</button>
                    @foreach($categories as $category)
                        <button class="btn {{ $categoryFilter == $category->id ? 'btn-gold' : 'btn-matte-outline' }} btn-sm rounded-pill px-3" wire:click="$set('categoryFilter', '{{ $category->id }}')">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="row g-4">
            @forelse($articles as $article)
            <div class="col-md-4">
                <div class="card h-100 bg-primary-navy border-secondary shadow-sm card-hover">
                    @if($article->image_path)
                    <img src="{{ $article->image_path }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-balance-scale fa-3x text-muted"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-2">
                            <span class="badge bg-soft-warning text-warning rounded-pill mb-2">{{ $article->category->name ?? 'Legal' }}</span>
                            <span class="text-muted small ms-2"><i class="far fa-clock me-1"></i> {{ $article->created_at->format('M d, Y') }}</span>
                        </div>
                        <h5 class="card-title fw-bold text-white mb-3">{{ $article->title }}</h5>
                        <p class="card-text text-muted small mb-4 flex-grow-1">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-secondary">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ $article->author->name ?? 'User' }}&background=random" class="rounded-circle me-2" width="30" height="30">
                                <small class="text-white-50">{{ $article->author->name ?? 'User' }}</small>
                            </div>
                            <a href="{{ route('article.details', $article->id) }}" class="btn btn-link text-warning p-0 text-decoration-none fw-bold">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="far fa-folder-open fa-4x text-muted mb-3 opacity-50"></i>
                    <h3 class="text-white-50">No articles found</h3>
                    <p class="text-muted">Try adjusting your search or category filter.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-top border-secondary d-flex align-items-center justify-content-between mt-5">
            <div class="text-muted small">
                Showing {{ $articles->firstItem() ?? 0 }} to {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} results
            </div>
            <div class="d-flex align-items-center gap-2">
                @if ($articles->onFirstPage())
                    <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5;">Previous</button>
                @else
                    <button wire:click="previousPage" class="btn btn-sm btn-outline-light">Previous</button>
                @endif

                <span class="text-muted small mx-2">Page {{ $articles->currentPage() }}</span>

                @if ($articles->hasMorePages())
                    <button wire:click="nextPage" class="btn btn-sm btn-outline-light">Next</button>
                @else
                    <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5;">Next</button>
                @endif
            </div>
        </div>
    <style>
        .search-matte {
            background: #1e293b; /* Slate-800 */
            border: 1px solid #334155; /* Slate-700 */
            transition: all 0.2s ease;
        }
        
        .search-matte:focus-within {
            border-color: #fbbf24; /* Warning/Gold */
            background: #0f172a; /* Slate-900 */
        }

        .btn-matte-outline {
            background: transparent;
            border: 1px solid #334155;
            color: #94a3b8;
        }
        .btn-matte-outline:hover {
            border-color: #fbbf24;
            color: #fbbf24;
        }
        
        .btn-gold {
            background: #fbbf24;
            color: #0f172a;
            border: 1px solid #fbbf24; /* Match border width of inactive state */
            font-weight: 600;
        }

        .placeholder-white-50::placeholder {
            color: #64748b;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
</div>
