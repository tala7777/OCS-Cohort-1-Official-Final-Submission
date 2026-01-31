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
 <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $approvedLawyers }}</h3>
                <p>Approved Lawyers</p>
            </div>
            <div class="stat-icon success">
                <i class="fas fa-gavel"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $pendingRequests }}</h3>
                <p>Pending Requests</p>
            </div>
            <div class="stat-icon warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalQuestions }}</h3>
                <p>Total Questions</p>
            </div>
            <div class="stat-icon info">
                <i class="fas fa-question-circle"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalAnswers }}</h3>
                <p>Total Answers</p>
            </div>
            <div class="stat-icon success">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalArticles }}</h3>
                <p>Total Articles</p>
            </div>
            <div class="stat-icon primary">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalCategories }}</h3>
                <p>Total Categories</p>
            </div>
            <div class="stat-icon warning">
                <i class="fas fa-tags"></i>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header border-0 pb-0 bg-transparent">
                    <h3 class="card-title mb-0">User Growth</h3>
                </div>
                <!-- Backend Note: Pass data for labels (months) and data (counts) -->
                <div class="card-body" wire:ignore>
                    <canvas id="userGrowthChart" style="max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header border-0 pb-0 bg-transparent">
                    <h3 class="card-title mb-0">Questions Distribution</h3>
                </div>
                <!-- Backend Note: Pass categories and their respective counts -->
                <div class="card-body" wire:ignore>
                    <canvas id="questionsChart" style="max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h3>Recent Questions</h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>User</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentQuestions as $question)
                        <tr wire:key="question-{{ $question->id }}">
                            <td class="fw-semibold">{{ $question->title }}</td>
                            <td>{{ $question->owner->name }}</td>
                            <td>
                                <span class="badge-outline-pill bg-soft-primary">
                                    {{ $question->category->name }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $question->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge {{ $question->status === 'open' ? 'badge-success' : ($question->status === 'closed' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ ucfirst($question->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-icon" wire:click="viewQuestion({{ $question->id }})"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                        @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Recent Lawyer Requests</h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>License No.</th>
                            <th>Date</th>
                            <th>CV</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentLawyerRequests as $request)
                        <tr wire:key="request-{{ $request->id }}">
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->email }}</td>
                            <td>{{ $request->license_number }}</td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($request->user->specializations as $spec)
                                                <span class="badge-outline-pill bg-soft-warning" style="font-size: 0.65rem; padding: 0.25rem 0.6rem;">
                                                    {{ $spec->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><span class="badge badge-warning">{{ $request->status }}</span></td>
                           <td>
                               @if ($request->status == 'pending')
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="confirmLawyerAction('Approve this lawyer request?', () => @this.approveRequest({{ $request->id }}))">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmLawyerAction('Reject this lawyer request?', () => @this.rejectRequest({{ $request->id }}))">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                        @elseif ($request->status == 'accepted')
                                        <span class="badge badge-success" >Accepted</span>
                                        @elseif ($request->status == 'rejected')
                                        <span class="badge badge-danger" wire:click="rejectRequest('{{$request->id}}')">Rejected</span>
                                        @endif
                                   
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-check-circle me-1 opacity-50"></i> No recent lawyer requests found.
                            </td>
                        </tr>
                        @endforelse
                       
                    </tbody>
                </table>
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
                        <strong>Category:</strong> 
                        <span class="badge-outline-pill bg-soft-primary ms-2">{{ $selectedQuestion->category->name }}</span>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle Action Confirmation
        function confirmLawyerAction(message, action) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                background: '#1e293b',
                color: '#e5e7eb',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    action();
                }
            });
        }

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

        // Livewire Event Listeners
        document.addEventListener('livewire:initialized', () => {

            // Initialize Charts
            const ctx1 = document.getElementById('userGrowthChart');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: @json($userGrowthLabels),
                        datasets: [{
                            label: 'New Users',
                            data: @json($userGrowthValues),
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                ticks: { color: '#94a3b8' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#94a3b8' }
                            }
                        }
                    }
                });
            }

            const ctx2 = document.getElementById('questionsChart');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: @json($categoryLabels),
                        datasets: [{
                            data: @json($categoryValues),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { color: '#94a3b8', usePointStyle: true, padding: 20 }
                            }
                        },
                        cutout: '75%'
                    }
                });
            }
        });
    </script>
</div>
