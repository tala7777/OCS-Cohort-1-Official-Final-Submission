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

    .btn-view-cv {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.2);
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-view-cv:hover {
        background: rgba(34, 197, 94, 0.2);
        transform: translateY(-1px);
        color: #22c55e;
    }

    /* Layout Fixes removed as they are now in admin.css or layout */

    .table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden; /* Force hide scrollbar */
    }

    /* Table Optimization to prevent scrolling */
    .table th, .table td {
        padding: 12px 8px !important; /* Reduce padding from 16px to 8px */
    }

    /* Truncate Email column */
    .table td:nth-child(3), .table th:nth-child(3) {
        max-width: 150px;
    }
    .table td:nth-child(3) {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Truncate Name column */
    .table td:nth-child(2), .table th:nth-child(2) {
        max-width: 110px;
    }
    .table td:nth-child(2) {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Constrain Category width */
    .table td:nth-child(4) {
        max-width: 180px;
    }

    /* Stack categories vertically and fix spacing */
    .table td:nth-child(4) .d-flex {
        flex-direction: column !important;
        align-items: center !important;
        gap: 4px !important;
    }

    /* Prevent badge text wrapping and refine style */
    .badge-gradient {
        white-space: nowrap;
        padding: 4px 10px !important;
        font-size: 11px !important;
    }

    /* Reduce font size slightly */
    .table {
        font-size: 13px !important;
    }
</style>
                <!-- Filters Bar -->
                <div class="filters-bar">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="form-label" >Search</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Search by name or email"
                                wire:model.live="search"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                wire:model.live="statusFilter"
                            >
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Rejected">Rejected</option>
                            </select>
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
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                wire:model.live="sort"
                            >
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Requests Table -->
                <!-- BACKEND: GET /admin/lawyer-requests -->
                <div class="table-wrapper">
                    <div class="table-header">
                        <h3 class="table-title">Verification Requests</h3>
                    </div>
                    
                    <div class="table-container">
                        <table class="table" id="requestsTable">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center" style="text-align: center !important;">Category</th>
                                    <th>License Number</th>
                                    <th>CV</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lawyers as $lawyer)
                                <tr wire:key="lawyer-{{ $lawyer->id }}">
                                    <td>REQ-{{$lawyer->id}}</td>
                                    <td class="fw-semibold">{{$lawyer->user->name}}</td>
                                    <td>{{$lawyer->user->email}}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 justify-content-center" style="justify-content: center !important;">
                                            @foreach ($lawyer->user->specializations as $category)
                                                <span class="badge-gradient">
                                                    {{$category->name}}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{$lawyer->license_number}}</td>
                                    <td>
                                        @if($lawyer->cv)
                                            <a href="{{ asset('storage/' . $lawyer->cv) }}" target="_blank" class="btn-view-cv">
                                                <i class="fas fa-file-pdf"></i> View CV
                                            </a>
                                        @else
                                            <span class="text-muted small">No CV Uploaded</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-warning">{{$lawyer->status}}</span></td>
                                    <td>{{$lawyer->created_at->format('Y-m-d')}}</td>
                                    <td>
                                        @if ($lawyer->status == 'pending')
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="confirmLawyerAction('Approve this lawyer request?', () => @this.approveRequest({{ $lawyer->id }}))">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmLawyerAction('Reject this lawyer request?', () => @this.rejectRequest({{ $lawyer->id }}))">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                        @elseif ($lawyer->status == 'accepted')
                                        <span class="badge badge-success" >Accepted</span>
                                        @elseif ($lawyer->status == 'rejected')
                                        <span class="badge badge-danger" wire:click="rejectRequest('{{$lawyer->id}}')">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                              
                                @endforeach                              
                            </tbody>
                        </table>
                </div>
            </div>
    <!-- JavaScript -->
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

    </script>
</div>
