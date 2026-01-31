<div>
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
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                wire:model.live="statusFilter"
                            >
                                <option value="">All Status</option>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                                <option value="answered">Answered</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                wire:model.live="sort"
                            >
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
                                <option value="answers-desc">Most Answered</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Questions Table -->
                <!-- BACKEND: GET /admin/questions -->
                <div class="table-wrapper">
                    <div class="table-header">
                        <h3 class="table-title">All Questions</h3>
                    </div>
                    
                    <div class="table-container">
                        <table class="table" id="questionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Created At</th>
                                    <th>Answers</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                <tr wire:key="question-{{ $question->id }}">
                                    <td>Q-{{ $question->id }}</td>
                                    <td class="fw-semibold">{{ $question->title }}</td>
                                    <td><span class="badge-gradient">{{ $question->category->name }}</span></td>
                                    <td>{{ $question->owner->name }}</td>
                                    <td>{{ $question->created_at }}</td>
                                    <td>{{ $question->replies->count() }}</td>
                                    <td>
                                        <span class="badge {{ $question->status === 'open' ? 'badge-success' : ($question->status === 'closed' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($question->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" wire:click="viewQuestion({{ $question->id }})" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn {{ $question->status === 'closed' ? 'btn-success' : 'btn-warning' }} btn-icon btn-sm" wire:click="toggleStatus({{ $question->id }})" title="{{ $question->status === 'closed' ? 'Open' : 'Close' }} Question">
                                                <i class="fas {{ $question->status === 'closed' ? 'fa-unlock' : 'fa-lock' }}"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="confirmQuestionAction('Are you sure you want to delete this question?', () => @this.deleteQuestion({{ $question->id }}))" title="Delete">
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


@if ($isViewQuestion)
    <div class="modal show" id="viewQuestionModal" style="display: flex !important; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;">
        <div class="modal-dialog" style="max-width: 700px; width: 100%; margin: 0;">
            <div class="modal-content" style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 0.5rem;">
                <div class="modal-header">
                    <h3 class="modal-title">Question Details</h3>
                    <button class="modal-close" wire:click="closeViewQuestion">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="viewQuestionContent">
                
                    <div class="mb-3">
                        <strong>Question ID:</strong> {{ $selectedQuestion->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Title:</strong> {{ $selectedQuestion->title }}
                    </div>
                    <div class="mb-3">
                        <strong>Category:</strong> <span class="badge-gradient">{{ $selectedQuestion->category->name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Author:</strong> {{ $selectedQuestion->owner->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $selectedQuestion->created_at }}
                    </div>
                    <div class="mb-3">
                        <strong>Body:</strong>
                        <p class="mt-2 text-wrap" style="word-break: break-word;">{{ $selectedQuestion->description }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Answers ({{ $selectedQuestion->replies->count() }}):</strong>
                        @foreach ($replies as $reply) 
                        <div class="mt-2 p-3 d-flex justify-content-between align-items-start" style="background-color: var(--bg-primary); border-radius: 0.375rem;">
                                <div>
                                    <p class="mb-1"><strong>{{ $reply->lawyer->name ?? 'Unknown User' }}</strong></p>
                                    <p class="text-muted small mb-0">{{ $reply->body }}</p>
                                </div>
                                <button class="btn btn-sm ms-3" style="background: transparent; border: none; color: #64748b; transition: color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#64748b'" onclick="confirmQuestionAction('Delete this reply?', () => @this.deleteReply({{ $reply->id }}))" title="Delete Reply">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </div>

                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" wire:click="closeViewQuestion">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle Action Confirmation
        function confirmQuestionAction(message, action) {
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
