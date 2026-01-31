<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles Management - Legal Q&A Admin</title>
    
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
            
            @include('partials.admin-topbar', ['title' => 'Articles Management'])

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
                                oninput="articleFilter.search(this.value)"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Category</label>
                            <select 
                                class="form-select"
                                onchange="articleFilter.filterByAttribute('category', this.value)"
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
                            <label class="form-label">Filter by Author</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Author name..."
                                oninput="articleFilter.search(this.value)"
                            >
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
                                <tr data-title="Understanding Corporate Governance in UAE" data-category="Corporate Law" data-author="Dr. Khalid Rahman" data-created="2026-01-13">
                                    <td>ART-1001</td>
                                    <td class="fw-semibold">Understanding Corporate Governance in UAE</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>Dr. Khalid Rahman</td>
                                    <td>2026-01-13</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1001')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1001')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Family Law Reforms in the UAE" data-category="Family Law" data-author="Layla Mansour" data-created="2026-01-12">
                                    <td>ART-1002</td>
                                    <td class="fw-semibold">Family Law Reforms in the UAE</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>Layla Mansour</td>
                                    <td>2026-01-12</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1002')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1002')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Criminal Procedure Code Updates 2026" data-category="Criminal Law" data-author="Omar Abdullah" data-created="2026-01-11">
                                    <td>ART-1003</td>
                                    <td class="fw-semibold">Criminal Procedure Code Updates 2026</td>
                                    <td><span class="badge badge-secondary">Criminal Law</span></td>
                                    <td>Omar Abdullah</td>
                                    <td>2026-01-11</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1003')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1003')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Intellectual Property Protection Strategies" data-category="IP Law" data-author="Noor Hassan" data-created="2026-01-10">
                                    <td>ART-1004</td>
                                    <td class="fw-semibold">Intellectual Property Protection Strategies</td>
                                    <td><span class="badge badge-secondary">IP Law</span></td>
                                    <td>Noor Hassan</td>
                                    <td>2026-01-10</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1004')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1004')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Real Estate Investment Laws in Dubai" data-category="Real Estate" data-author="Mohammed Saeed" data-created="2026-01-09">
                                    <td>ART-1005</td>
                                    <td class="fw-semibold">Real Estate Investment Laws in Dubai</td>
                                    <td><span class="badge badge-secondary">Real Estate</span></td>
                                    <td>Mohammed Saeed</td>
                                    <td>2026-01-09</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1005')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1005')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Starting a Business in UAE Free Zones" data-category="Corporate Law" data-author="Dr. Khalid Rahman" data-created="2026-01-08">
                                    <td>ART-1006</td>
                                    <td class="fw-semibold">Starting a Business in UAE Free Zones</td>
                                    <td><span class="badge badge-secondary">Corporate Law</span></td>
                                    <td>Dr. Khalid Rahman</td>
                                    <td>2026-01-08</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1006')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1006')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Divorce and Custody Rights for Expats" data-category="Family Law" data-author="Layla Mansour" data-created="2026-01-07">
                                    <td>ART-1007</td>
                                    <td class="fw-semibold">Divorce and Custody Rights for Expats</td>
                                    <td><span class="badge badge-secondary">Family Law</span></td>
                                    <td>Layla Mansour</td>
                                    <td>2026-01-07</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1007')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1007')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-title="Cybercrime Laws in the UAE" data-category="Criminal Law" data-author="Aisha Khan" data-created="2026-01-06">
                                    <td>ART-1008</td>
                                    <td class="fw-semibold">Cybercrime Laws in the UAE</td>
                                    <td><span class="badge badge-secondary">Criminal Law</span></td>
                                    <td>Aisha Khan</td>
                                    <td>2026-01-06</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewArticle('ART-1008')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteArticle('ART-1008')" title="Delete">
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

    <!-- View Article Modal -->
    <div class="modal" id="viewArticleModal">
        <div class="modal-dialog" style="max-width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">Article Details</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewArticleContent">
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
        const articleFilter = new TableFilter('articlesTable');
        
        // View article details
        function viewArticle(articleId) {
            // BACKEND: GET /admin/articles/{articleId}
            const content = `
                <div class="mb-3">
                    <strong>Article ID:</strong> ${articleId}
                </div>
                <div class="mb-3">
                    <strong>Title:</strong> Sample Article Title
                </div>
                <div class="mb-3">
                    <strong>Category:</strong> <span class="badge badge-secondary">Corporate Law</span>
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> Dr. Khalid Rahman
                </div>
                <div class="mb-3">
                    <strong>Published:</strong> 2026-01-10
                </div>
                <div class="mb-3">
                    <strong>Content:</strong>
                    <div class="mt-2 p-3" style="background-color: var(--bg-primary); border-radius: 0.375rem;">
                        <p>This is a sample article content that would contain the full article text, formatting, and any embedded media...</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            `;
            document.getElementById('viewArticleContent').innerHTML = content;
            Modal.open('viewArticleModal');
        }
        
        // Delete article
        function deleteArticle(articleId) {
            // BACKEND: DELETE /admin/articles/{articleId}
            confirmAction('Are you sure you want to delete this article? This action cannot be undone.', () => {
                Toast.info('Demo Mode: Article deletion will be connected to PHP backend later.');
            });
        }
        
        // Handle sort
        function handleSort(value) {
            const [attr, order] = value.split('-');
            articleFilter.sortBy(attr, order);
        }
    </script>
</body>
</html>

