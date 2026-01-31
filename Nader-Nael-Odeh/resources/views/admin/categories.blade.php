<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management - Legal Q&A Admin</title>
    
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
            
            @include('partials.admin-topbar', ['title' => 'Categories Management'])

            <div class="content-wrapper">
                <!-- Info Alert -->
                <div class="card mb-3" style="border-left: 4px solid var(--info);">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle" style="color: var(--info); font-size: 1.25rem;"></i>
                            <div>
                                <strong>Unified Categories System</strong>
                                <p class="mb-0 text-secondary" style="font-size: 0.875rem;">
                                    These categories are used across Questions, Lawyers, and Articles. 
                                    Categories in use should be deactivated instead of deleted to maintain data integrity.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Table -->
                <!-- BACKEND: GET /admin/categories -->
                <div class="table-wrapper">
                    <div class="table-header">
                        <h3 class="table-title">All Categories</h3>
                        <button class="btn btn-primary" onclick="Modal.open('addCategoryModal')">
                            <i class="fas fa-plus"></i>
                            Add Category
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Usage Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-name="Corporate Law" data-status="Active">
                                    <td>CAT-001</td>
                                    <td class="fw-semibold">Corporate Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>245 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-001')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-001', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Family Law" data-status="Active">
                                    <td>CAT-002</td>
                                    <td class="fw-semibold">Family Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>189 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-002')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-002', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Criminal Law" data-status="Active">
                                    <td>CAT-003</td>
                                    <td class="fw-semibold">Criminal Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>156 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-003')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-003', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="IP Law" data-status="Active">
                                    <td>CAT-004</td>
                                    <td class="fw-semibold">IP Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>98 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-004')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-004', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Real Estate" data-status="Active">
                                    <td>CAT-005</td>
                                    <td class="fw-semibold">Real Estate</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>134 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-005')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-005', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Employment Law" data-status="Active">
                                    <td>CAT-006</td>
                                    <td class="fw-semibold">Employment Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>112 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-006')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-006', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Tax Law" data-status="Active">
                                    <td>CAT-007</td>
                                    <td class="fw-semibold">Tax Law</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>67 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-007')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-007', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Banking & Finance" data-status="Inactive">
                                    <td>CAT-008</td>
                                    <td class="fw-semibold">Banking & Finance</td>
                                    <td><span class="badge badge-secondary">Inactive</span></td>
                                    <td>23 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-008')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm" onclick="toggleCategory('CAT-008', 'activate')" title="Activate">
                                                <i class="fas fa-check"></i> Activate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Immigration" data-status="Active">
                                    <td>CAT-009</td>
                                    <td class="fw-semibold">Immigration</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>45 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-009')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-009', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Consumer Rights" data-status="Active">
                                    <td>CAT-010</td>
                                    <td class="fw-semibold">Consumer Rights</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>78 items</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editCategory('CAT-010')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="toggleCategory('CAT-010', 'deactivate')" title="Deactivate">
                                                <i class="fas fa-ban"></i> Deactivate
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

    <!-- Add Category Modal -->
    <div class="modal" id="addCategoryModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Add New Category</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- BACKEND: POST /admin/categories -->
                <form id="addCategoryForm">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g., Maritime Law" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Cancel</button>
                <button class="btn btn-primary" onclick="addCategory()">Add Category</button>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal" id="editCategoryModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Edit Category</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- BACKEND: PATCH /admin/categories/{id} -->
                <form id="editCategoryForm">
                    <input type="hidden" name="category_id" id="editCategoryId">
                    
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Cancel</button>
                <button class="btn btn-primary" onclick="saveCategory()">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script src="{{ asset('assets/js/admin-ui.js') }}"></script>
    <script>
        // Initialize table filter
        const categoryFilter = new TableFilter('categoriesTable');
        
        // Add new category
        function addCategory() {
            // BACKEND: POST /admin/categories
            const formData = getFormData('addCategoryForm');
            Toast.success('Demo Mode: Category creation will be connected to PHP backend later.');
            Modal.close('addCategoryModal');
            resetForm('addCategoryForm');
        }
        
        // Edit category
        function editCategory(categoryId) {
            // BACKEND: GET /admin/categories/{categoryId}
            populateEditForm('editCategoryForm', {
                category_id: categoryId,
                name: 'Sample Category',
                status: 'Active'
            });
            Modal.open('editCategoryModal');
        }
        
        // Save category changes
        function saveCategory() {
            // BACKEND: PATCH /admin/categories/{id}
            const formData = getFormData('editCategoryForm');
            Toast.success('Demo Mode: Category update will be connected to PHP backend later.');
            Modal.close('editCategoryModal');
        }
        
        // Toggle category status
        function toggleCategory(categoryId, action) {
            // BACKEND: PATCH /admin/categories/{categoryId}
            const message = action === 'deactivate' 
                ? 'Are you sure you want to deactivate this category? It will be hidden from new content but existing content will remain.'
                : 'Are you sure you want to activate this category?';
            
            confirmAction(message, () => {
                Toast.info(`Demo Mode: Category ${action} will be connected to PHP backend later.`);
            });
        }
        
        // Delete category (only if not in use)
        function deleteCategory(categoryId) {
            // BACKEND: DELETE /admin/categories/{categoryId}
            confirmAction('Are you sure you want to delete this category? This is only possible if no content is using it.', () => {
                Toast.warning('Demo Mode: Category deletion will be connected to PHP backend later. Backend will check for usage before allowing deletion.');
            });
        }
    </script>
</body>
</html>

