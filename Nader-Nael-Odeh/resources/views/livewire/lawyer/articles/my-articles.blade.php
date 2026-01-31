

<div>
   <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div></div> <!-- Spacer -->
            <a href="{{ route('lawyer.articles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Write New Article
            </a>
        </div>

      
        <!-- Articles List -->
        <!-- BACKEND: GET /lawyer/articles -->
        <div id="articlesContainer">
            <div class="row g-4">
                <!-- Sample Article 1 -->
                 @foreach ($articles as $article)
                <div class="col-12">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2">{{$article->title}}</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="fas fa-tag me-1"></i>{{$article->category->name}}</span>
                                        <span><i class="fas fa-calendar me-1"></i>{{$article->created_at->format('Y-m-d')}}</span>
                                        <span><i class="fas fa-eye me-1"></i>{{$article->views}} views</span>
                                    </div>
                                </div>
                                <span class="badge bg-success">Published</span>
                            </div>
                            <p class="text-secondary mb-3">
                                {{$article->content}}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('article.details', $article->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('lawyer.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ $this->getId() }}', '{{ $article->id }}')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                  @endforeach
            

                <!-- Sample Draft -->
                @foreach ($drafts as $draft)
                <div class="col-12">
                    <div class="card card-hover shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2">{{$draft->title}}</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="fas fa-tag me-1"></i>{{$draft->category->name}}</span>
                                        <span><i class="fas fa-calendar me-1"></i>{{$draft->created_at->format('Y-m-d')}}</span>
                                    </div>
                                </div>
                                <span class="badge bg-secondary">Draft</span>
                            </div>
                            <p class="text-secondary mb-3">
                                {{$draft->content}}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('lawyer.articles.edit', $draft->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pen me-1"></i>Continue Writing
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ $this->getId() }}', '{{ $draft->id }}')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State (Hidden for demo since we have items) -->
            <div id="emptyState" style="display: none;">
                <div class="text-center py-5">
                    <i class="fas fa-file-alt text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h4 class="mt-3 text-secondary">No Articles Yet</h4>
                    <p class="text-muted">Start sharing your legal expertise by writing your first article.</p>
                    <a href="{{ route('lawyer.articles.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Write Your First Article
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(componentId, articleId) {
            Swal.fire({
                title: 'Delete Article?',
                text: "This action cannot be undone!",
                icon: 'warning',
                background: '#1e293b', // Matches admin/public pages theme
                color: '#e5e7eb',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary',
                    popup: 'border border-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        background: '#1e293b', 
                        color: '#e5e7eb',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    Livewire.find(componentId).delete(articleId).then(() => {
                        Swal.close();
                    });
                }
            })
        }
    </script>
</div>
