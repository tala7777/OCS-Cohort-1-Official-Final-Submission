<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Requests - Legal Q&A Admin</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/shared.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        
        @include('partials.admin-sidebar')

        <!-- Main Content -->
        <main class="admin-content">
            
            @include('partials.admin-topbar', ['title' => 'Lawyer Verification Requests'])

            <div class="content-wrapper">
                <!-- Filters Bar -->
                <div class="filters-bar">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="form-label">Search</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Search by name, email, or bar number..."
                                oninput="requestFilter.search(this.value)"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                onchange="requestFilter.filterByAttribute('status', this.value)"
                            >
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Category</label>
                            <select 
                                class="form-select"
                                onchange="requestFilter.filterByAttribute('category', this.value)"
                            >
                                <option value="">All Categories</option>
                                <option value="Corporate Law">Corporate Law</option>
                                <option value="Family Law">Family Law</option>
                                <option value="Criminal Law">Criminal Law</option>
                                <option value="IP Law">IP Law</option>
                                <option value="Real Estate">Real Estate</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                onchange="handleSort(this.value)"
                            >
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
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
                                    <th>Category</th>
                                    <th>Bar Number</th>
                                    <th>CV</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-status="Pending" data-category="Corporate Law" data-email="khalid.rahman@lawfirm.ae" data-created="2026-01-13">
                                    <td>REQ-1001</td>
                                    <td class="fw-semibold">Dr. Khalid Rahman</td>
                                    <td>khalid.rahman@lawfirm.ae</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>BAR-UAE-45678</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2026-01-13</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest('REQ-1001')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest('REQ-1001')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-status="Pending" data-category="Family Law" data-email="layla.mansour@legal.ae" data-created="2026-01-12">
                                    <td>REQ-1002</td>
                                    <td class="fw-semibold">Layla Mansour</td>
                                    <td>layla.mansour@legal.ae</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>BAR-UAE-34567</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2026-01-12</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest('REQ-1002')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest('REQ-1002')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-status="Approved" data-category="Criminal Law" data-email="omar.abdullah@advocates.ae" data-created="2026-01-11">
                                    <td>REQ-1003</td>
                                    <td class="fw-semibold">Omar Abdullah</td>
                                    <td>omar.abdullah@advocates.ae</td>
                                    <td><span class="badge badge-secondary">Criminal Law</span></td>
                                    <td>BAR-UAE-23456</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                    <td>2026-01-11</td>
                                    <td>
                                        <span class="text-muted">Approved</span>
                                    </td>
                                </tr>
                                
                                <tr data-status="Pending" data-category="IP Law" data-email="noor.hassan@legal.ae" data-created="2026-01-10">
                                    <td>REQ-1004</td>
                                    <td class="fw-semibold">Noor Hassan</td>
                                    <td>noor.hassan@legal.ae</td>
                                    <td><span class="badge badge-secondary">IP Law</span></td>
                                    <td>BAR-UAE-12345</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2026-01-10</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest('REQ-1004')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest('REQ-1004')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-status="Rejected" data-category="Real Estate" data-email="fake.lawyer@email.com" data-created="2026-01-09">
                                    <td>REQ-1005</td>
                                    <td class="fw-semibold">John Doe</td>
                                    <td>fake.lawyer@email.com</td>
                                    <td><span class="badge badge-secondary">Real Estate</span></td>
                                    <td>BAR-INVALID</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-danger">Rejected</span></td>
                                    <td>2026-01-09</td>
                                    <td>
                                        <span class="text-muted">Rejected</span>
                                    </td>
                                </tr>
                                
                                <tr data-status="Pending" data-category="Corporate Law" data-email="yasmin.ali@lawfirm.ae" data-created="2026-01-08">
                                    <td>REQ-1006</td>
                                    <td class="fw-semibold">Yasmin Ali</td>
                                    <td>yasmin.ali@lawfirm.ae</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>BAR-UAE-56789</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2026-01-08</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest('REQ-1006')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest('REQ-1006')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-status="Approved" data-category="Family Law" data-email="mohammed.saeed@legal.ae" data-created="2026-01-07">
                                    <td>REQ-1007</td>
                                    <td class="fw-semibold">Mohammed Saeed</td>
                                    <td>mohammed.saeed@legal.ae</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>BAR-UAE-67890</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                    <td>2026-01-07</td>
                                    <td>
                                        <span class="text-muted">Approved</span>
                                    </td>
                                </tr>
                                
                                <tr data-status="Pending" data-category="Criminal Law" data-email="aisha.khan@advocates.ae" data-created="2026-01-06">
                                    <td>REQ-1008</td>
                                    <td class="fw-semibold">Aisha Khan</td>
                                    <td>aisha.khan@advocates.ae</td>
                                    <td><span class="badge badge-secondary">Criminal Law</span></td>
                                    <td>BAR-UAE-78901</td>
                                    <td><a href="#" class="text-primary" onclick="demoAction('View CV')"><i class="fas fa-file-pdf"></i> View</a></td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>2026-01-06</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest('REQ-1008')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest('REQ-1008')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script src="{{ asset('assets/js/admin-ui.js') }}"></script>
    <script>
        // Initialize table filter
        const requestFilter = new TableFilter('requestsTable');
        
        // Approve request
        function approveRequest(requestId) {
            // BACKEND: POST /admin/lawyer-requests/{requestId}/approve
            confirmAction('Are you sure you want to approve this lawyer verification request?', () => {
                Toast.success('Demo Mode: Lawyer approval will be connected to PHP backend later.');
            });
        }
        
        // Reject request
        function rejectRequest(requestId) {
            // BACKEND: POST /admin/lawyer-requests/{requestId}/reject
            confirmAction('Are you sure you want to reject this lawyer verification request?', () => {
                Toast.error('Demo Mode: Lawyer rejection will be connected to PHP backend later.');
            });
        }
        
        // Handle sort
        function handleSort(value) {
            const [attr, order] = value.split('-');
            requestFilter.sortBy(attr, order);
        }
    </script>
</body>
</html>

