<div>
    <style>
        .badge-gradient {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.025em;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
        }

        /* Pagination Dark Mode Styling */
        .page-link {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #f1f5f9 !important;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);
        }

        .page-item.disabled .page-link {
            background-color: rgba(255, 255, 255, 0.02) !important;
            color: #475569 !important;
            border-color: transparent !important;
        }
        
        /* Hide awkward rounded corners on groups since we use margins */
        .page-item:first-child .page-link, 
        .page-item:last-child .page-link {
            border-radius: 8px !important;
        }
    </style>
            
          

    <!-- Flash Messages (Simple Design) -->
    @if (session()->has('success'))
        <div class="alert simple-alert simple-alert-success mb-4" role="alert">
            <i class="fas fa-check-circle"></i>
            <div class="alert-content">
                <span class="alert-title">Success:</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert simple-alert simple-alert-danger mb-4" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-content">
                <span class="alert-title">Error:</span>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
                <!-- Filters Bar -->
                <div class="filters-bar">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="form-label">Search</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Search by title..."
                                wire:model.live="search"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Category</label>
                            <select 
                                class="form-select"
                                wire:model.live="categoryFilter"
                            >
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Author</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Author name..."
                                wire:model.live="authorFilter"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                wire:model.live="sort"
                            >
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Articles Table -->
                <!-- BACKEND: GET /admin/articles -->
                <div class="table-wrapper">
                    <div class="table-header">
                        <h3 class="table-title">All Articles</h3>
                    </div>
                    
                    <div class="table-container">
                        <table class="table" id="articlesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Published At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                <tr wire:key="article-{{ $article->id }}">
                                    <td>{{ $article->id }}</td>
                                    <td class="fw-semibold">{{ $article->title }}</td>
                                    <td><span class="badge badge-secondary">{{ $article->category->name }}</span></td>
                                    <td>{{ $article->author->name }}</td>
                                    <td>{{ $article->created_at }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" wire:click="viewArticle('{{ $article->id }}')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="confirmArticleAction('Are you sure you want to delete this article?', () => @this.deleteArticle('{{ $article->id }}'))" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                         <div class="px-4 py-3 border-top border-white/10 d-flex align-items-center justify-content-between" style="border-top: 1px solid rgba(255,255,255,0.1);">
                        <div class="text-muted small">
                            Showing {{ $articles->firstItem() ?? 0 }} to {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} results
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if ($articles->onFirstPage())
                                <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                            @else
                                <button wire:click="previousPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                            @endif

                            <span class="text-muted small mx-2">
                                Page {{ $articles->currentPage() }} of {{ $articles->lastPage() }}
                            </span>

                            @if ($articles->hasMorePages())
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
    
    
    
    
    @if($isViewArticle)
    
     <div class="modal show" id="viewArticleModal" style="display: flex !important; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;">
        <div class="modal-dialog" style="max-width: 800px; width: 100%; margin: 0;">
            <div class="modal-content" style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 0.5rem;">
            <div class="modal-header">
                <h3 class="modal-title">Article Details</h3>
                <button class="modal-close" wire:click="closeViewArticle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewArticleContent">
                <div class="mb-3">
                    <strong>Article ID:</strong> {{ $selectedArticle->id }}
                </div>
                <div class="mb-3">
                    <strong>Title:</strong> {{ $selectedArticle->title }}
                </div>
                <div class="mb-3">
                    <strong>Category:</strong> <span class="badge badge-secondary">{{ $selectedArticle->category->name }}</span>
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> {{ $selectedArticle->author->name }}
                </div>
                <div class="mb-3">
                    <strong>Published:</strong> {{ $selectedArticle->created_at }}
                </div>
                <div class="mb-3">
                    <strong>Content:</strong>
                    <div class="mt-2 p-3" style="background-color: var(--bg-primary); border-radius: 0.375rem;">
                        {{ $selectedArticle->content }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" wire:click="closeViewArticle">Close</button>
            </div>
        </div>
    </div>
    @endif
    
    
    
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle Article Action Confirmation
        function confirmArticleAction(message, action) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                background: '#1e293b',
                color: '#e5e7eb',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    action();
                }
            });
        }

    </script>
</div>
