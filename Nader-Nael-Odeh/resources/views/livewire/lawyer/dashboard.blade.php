<div>
  <div class="row g-4 mb-4">
        <!-- Stats Cards -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e2130 0%, #161925 100%);">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center position-relative z-1">
                        <div>
                            <p class="text-primary text-uppercase fw-bold mb-2 small letter-spacing-1">Total Answers</p>
                            <h2 class="display-4 fw-bold text-white mb-0">{{ $answers }}</h2>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-4">
                            <i class="fas fa-comments fa-3x text-primary opacity-75"></i>
                        </div>
                    </div>
                    <!-- Decorative Circle -->
                    <div class="position-absolute top-0 end-0 translate-middle-y me-n5 mt-n5 opacity-5" style="width: 200px; height: 200px; background: radial-gradient(circle, var(--bs-primary) 0%, transparent 70%); border-radius: 50%;"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e2130 0%, #161925 100%);">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center position-relative z-1">
                        <div>
                            <p class="text-success text-uppercase fw-bold mb-2 small letter-spacing-1">Published Articles</p>
                            <h2 class="display-4 fw-bold text-white mb-0">{{ $articles }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-4">
                            <i class="fas fa-file-alt fa-3x text-success opacity-75"></i>
                        </div>
                    </div>
                     <!-- Decorative Circle -->
                     <div class="position-absolute top-0 end-0 translate-middle-y me-n5 mt-n5 opacity-5" style="width: 200px; height: 200px; background: radial-gradient(circle, var(--bs-success) 0%, transparent 70%); border-radius: 50%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Questions -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>Recent Questions</h5>
                    <a href="{{ route('lawyer.questions.index') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($questions as $question)
                    <a href="{{ route('lawyer.questions.answer', $question->id) }}" class="list-group-item list-group-item-action bg-transparent border-secondary p-3">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-1 fw-bold text-white">{{ $question->title }}</h6>
                            <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-muted small">{{ $question->category->name }} • {{ $question->replies->count() }} Answers</p>
                    </a>
                   @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('lawyer.questions.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Questions
                        </a>
                        <a href="{{ route('lawyer.articles.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Write Article
                        </a>
                        <a href="{{ route('lawyer.answers.index') }}" class="btn btn-info text-white">
                            <i class="fas fa-comments me-2"></i>My Answers
                        </a>
                        <a href="{{ route('lawyer.profile.edit') }}" class="btn btn-secondary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
