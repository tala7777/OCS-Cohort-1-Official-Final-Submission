<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions Management - Legal Q&A Admin</title>
    
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
            
            @include('partials.admin-topbar', ['title' => 'Questions Management'])

            <div class="content-wrapper">
                <!-- Filters Bar -->
                <div class="filters-bar">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="form-label">Search</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Search by title..."
                                oninput="questionFilter.search(this.value)"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Category</label>
                            <select 
                                class="form-select"
                                onchange="questionFilter.filterByAttribute('category', this.value)"
                            >
                                <option value="">All Categories</option>
                                <option value="Corporate Law">Corporate Law</option>
                                <option value="Family Law">Family Law</option>
                                <option value="Criminal Law">Criminal Law</option>
                                <option value="IP Law">IP Law</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Employment Law">Employment Law</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                onchange="questionFilter.filterByAttribute('status', this.value)"
                            >
                                <option value="">All Status</option>
                                <option value="Open">Open</option>
                                <option value="Answered">Answered</option>
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
                                <tr data-title="How to register a trademark in UAE?" data-category="IP Law" data-status="Open" data-created="2026-01-13" data-answers="0">
                                    <td>Q-1001</td>
                                    <td class="fw-semibold">How to register a trademark in UAE?</td>
                                    <td><span class="badge badge-secondary">IP Law</span></td>
                                    <td>Ahmed Hassan</td>
                                    <td>2026-01-13</td>
                                    <td>0</td>
                                    <td><span class="badge badge-warning">Open</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1001')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1001')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Employment contract termination notice period" data-category="Employment Law" data-status="Answered" data-created="2026-01-13" data-answers="2">
                                    <td>Q-1002</td>
                                    <td class="fw-semibold">Employment contract termination notice period</td>
                                    <td><span class="badge badge-secondary">Employment Law</span></td>
                                    <td>Sara Mohammed</td>
                                    <td>2026-01-13</td>
                                    <td>2</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1002')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1002')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="LLC vs Free Zone company setup" data-category="Corporate Law" data-status="Answered" data-created="2026-01-12" data-answers="3">
                                    <td>Q-1003</td>
                                    <td class="fw-semibold">LLC vs Free Zone company setup</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>John Smith</td>
                                    <td>2026-01-12</td>
                                    <td>3</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1003')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1003')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Divorce proceedings timeline in Dubai" data-category="Family Law" data-status="Open" data-created="2026-01-12" data-answers="0">
                                    <td>Q-1004</td>
                                    <td class="fw-semibold">Divorce proceedings timeline in Dubai</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>Fatima Ali</td>
                                    <td>2026-01-12</td>
                                    <td>0</td>
                                    <td><span class="badge badge-warning">Open</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1004')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1004')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Real estate purchase contract review" data-category="Real Estate" data-status="Answered" data-created="2026-01-11" data-answers="1">
                                    <td>Q-1005</td>
                                    <td class="fw-semibold">Real estate purchase contract review</td>
                                    <td><span class="badge badge-secondary">Real Estate</span></td>
                                    <td>Michael Brown</td>
                                    <td>2026-01-11</td>
                                    <td>1</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1005')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1005')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Criminal defense lawyer consultation" data-category="Criminal Law" data-status="Answered" data-created="2026-01-10" data-answers="2">
                                    <td>Q-1006</td>
                                    <td class="fw-semibold">Criminal defense lawyer consultation</td>
                                    <td><span class="badge badge-secondary">Criminal Law</span></td>
                                    <td>Ali Hassan</td>
                                    <td>2026-01-10</td>
                                    <td>2</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1006')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1006')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Patent application process in UAE" data-category="IP Law" data-status="Open" data-created="2026-01-09" data-answers="0">
                                    <td>Q-1007</td>
                                    <td class="fw-semibold">Patent application process in UAE</td>
                                    <td><span class="badge badge-secondary">IP Law</span></td>
                                    <td>Noor Ahmed</td>
                                    <td>2026-01-09</td>
                                    <td>0</td>
                                    <td><span class="badge badge-warning">Open</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1007')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1007')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Child custody laws in UAE" data-category="Family Law" data-status="Answered" data-created="2026-01-08" data-answers="4">
                                    <td>Q-1008</td>
                                    <td class="fw-semibold">Child custody laws in UAE</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>Mariam Khalid</td>
                                    <td>2026-01-08</td>
                                    <td>4</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1008')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1008')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Business license renewal requirements" data-category="Corporate Law" data-status="Open" data-created="2026-01-07" data-answers="0">
                                    <td>Q-1009</td>
                                    <td class="fw-semibold">Business license renewal requirements</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>Omar Saeed</td>
                                    <td>2026-01-07</td>
                                    <td>0</td>
                                    <td><span class="badge badge-warning">Open</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1009')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1009')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Tenant rights in Dubai rental disputes" data-category="Real Estate" data-status="Answered" data-created="2026-01-06" data-answers="3">
                                    <td>Q-1010</td>
                                    <td class="fw-semibold">Tenant rights in Dubai rental disputes</td>
                                    <td><span class="badge badge-secondary">Real Estate</span></td>
                                    <td>Yasmin Ali</td>
                                    <td>2026-01-06</td>
                                    <td>3</td>
                                    <td><span class="badge badge-success">Answered</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewQuestion('Q-1010')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteQuestion('Q-1010')" title="Delete">
                                                <i class="fas fa-trash"></i>
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

    <!-- View Question Modal -->
    <div class="modal" id="viewQuestionModal">
        <div class="modal-dialog" style="max-width: 700px;">
            <div class="modal-header">
                <h3 class="modal-title">Question Details</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewQuestionContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Close</button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script src="{{ asset('assets/js/admin-ui.js') }}"></script>
    <script>
        // Initialize table filter
        const questionFilter = new TableFilter('questionsTable');
        
        // View question details
        function viewQuestion(questionId) {
            // BACKEND: GET /admin/questions/{questionId}
            const content = `
                <div class="mb-3">
                    <strong>Question ID:</strong> ${questionId}
                </div>
                <div class="mb-3">
                    <strong>Title:</strong> Sample Question Title
                </div>
                <div class="mb-3">
                    <strong>Category:</strong> <span class="badge badge-secondary">Corporate Law</span>
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> John Doe
                </div>
                <div class="mb-3">
                    <strong>Created:</strong> 2026-01-10
                </div>
                <div class="mb-3">
                    <strong>Body:</strong>
                    <p class="mt-2">This is a sample question body that would contain the full question details...</p>
                </div>
                <div class="mb-3">
                    <strong>Answers (2):</strong>
                    <div class="mt-2 p-3" style="background-color: var(--bg-primary); border-radius: 0.375rem;">
                        <p class="mb-1"><strong>Dr. Khalid Rahman:</strong></p>
                        <p class="text-muted small mb-0">Sample answer content here...</p>
                    </div>
                </div>
            `;
            document.getElementById('viewQuestionContent').innerHTML = content;
            Modal.open('viewQuestionModal');
        }
        
        // Delete question
        function deleteQuestion(questionId) {
            // BACKEND: DELETE /admin/questions/{questionId}
            confirmAction('Are you sure you want to delete this question? This will also delete all associated answers.', () => {
                Toast.info('Demo Mode: Question deletion will be connected to PHP backend later.');
            });
        }
        
        // Handle sort
        function handleSort(value) {
            const [attr, order] = value.split('-');
            questionFilter.sortBy(attr, order);
        }
    </script>
</body>
</html>

