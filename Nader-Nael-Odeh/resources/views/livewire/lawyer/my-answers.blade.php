<div>

    <div class="card shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Answers ({{ $questions->count() }})</h5>
            <div class="col-md-3 d-flex gap-2">
                <select class="form-select form-select-sm" wire:model.live="sort">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
                <select class="form-select form-select-sm" wire:model.live="category">
                    <option value="">All Categories</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="list-group list-group-flush">
            @foreach ($questions as $question)
            <div class="list-group-item p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-1">
                        <a href="{{ url('/question-details/'.$question->id) }}" class="text-decoration-none text-white fw-bold">{{ $question->title }}</a>
                    </h6>
                    <span class="badge bg-info">{{ $question->category->name }}</span>
                </div>
                <div class="p-3 bg-transparent border border-secondary rounded text-muted mb-3 small fst-italic">
                    {{ $question->replies->first()?->body }}
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        <i class="fas fa-thumbs-up me-1 text-primary"></i> 15 Helpful • Answered 2 days ago
                    </div>
                    <div>
                        <a href="{{ route('lawyer.answers.edit', $question->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $question->id }})">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach            
            
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('open-delete-modal', () => {
                Swal.fire({
                    title: 'Delete Answer?',
                    text: "Are you sure you want to permanently remove this answer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Delete It',
                    background: '#1a202c',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteAnswer');
                    }
                });
            });
        });
    </script>
</div>
</div>
