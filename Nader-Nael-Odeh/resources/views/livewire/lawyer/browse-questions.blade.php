<div>
  <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Search..." wire:model.live="search">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="statusFilter">
                        <option value="">All Status</option>
                        <option value="unanswered">Unanswered</option>
                        <option value="answered">Answered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="dateFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                </div>
                
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h5 class="mb-0">Questions Awaiting Answers</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="40%">Question</th>
                        <th>Category</th>
                        <th>Asked</th>
                        <th>Answers</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                    <tr>
                        <td>
                            <a href="#" class="text-decoration-none fw-bold text-white">{{ $question->title }}</a>
                            <p class="text-muted small mb-0 text-truncate" style="max-width: 300px;">{{ $question->content }}</p>
                        </td>
                        <td><span class="badge bg-primary">{{ $question->category->name }}</span></td>
                        <td>{{ $question->created_at->diffForHumans() }}</td>
                        <td><span class="badge bg-secondary">{{ $question->replies->count() }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('lawyer.questions.answer', $question->id) }}" class="btn btn-sm btn-success">Answer</a>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
        </div>
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
    </div></div>
