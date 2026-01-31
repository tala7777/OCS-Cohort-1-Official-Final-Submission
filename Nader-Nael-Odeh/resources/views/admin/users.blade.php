<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Legal Q&A Admin</title>
    
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
            
            @include('partials.admin-topbar', ['title' => 'User Management'])

            <div class="content-wrapper">
                <!-- Filters Bar -->
                <div class="filters-bar">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="form-label">Search</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Search by name or email..."
                                id="searchInput"
                                oninput="userFilter.search(this.value)"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Role</label>
                            <select 
                                class="form-select"
                                id="roleFilter"
                                onchange="userFilter.filterByAttribute('role', this.value)"
                            >
                                <option value="">All Roles</option>
                                <option value="User">User</option>
                                <option value="Lawyer">Lawyer</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                id="statusFilter"
                                onchange="userFilter.filterByAttribute('status', this.value)"
                            >
                                <option value="">All Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Suspended">Suspended</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                id="sortSelect"
                                onchange="handleSort(this.value)"
                            >
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <!-- BACKEND: GET /admin/users -->
                <div class="table-wrapper">
                    <div class="table-header">
                        <h3 class="table-title">All Users</h3>
                        <button class="btn btn-primary" onclick="Modal.open('addUserModal')">
                            <i class="fas fa-plus"></i>
                            Add User
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-name="Ahmed Hassan" data-email="ahmed.hassan@email.com" data-role="User" data-status="Active" data-created="2026-01-10">
                                    <td>1001</td>
                                    <td class="fw-semibold">Ahmed Hassan</td>
                                    <td>ahmed.hassan@email.com</td>
                                    <td><span class="badge badge-info">User</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-10</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1001)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1001)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1001)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Dr. Khalid Rahman" data-email="khalid.rahman@lawfirm.ae" data-role="Lawyer" data-status="Active" data-created="2026-01-09">
                                    <td>1002</td>
                                    <td class="fw-semibold">Dr. Khalid Rahman</td>
                                    <td>khalid.rahman@lawfirm.ae</td>
                                    <td><span class="badge badge-primary">Lawyer</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-09</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1002)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1002)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1002)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Sara Mohammed" data-email="sara.mohammed@email.com" data-role="User" data-status="Active" data-created="2026-01-08">
                                    <td>1003</td>
                                    <td class="fw-semibold">Sara Mohammed</td>
                                    <td>sara.mohammed@email.com</td>
                                    <td><span class="badge badge-info">User</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-08</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1003)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1003)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1003)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Layla Mansour" data-email="layla.mansour@legal.ae" data-role="Lawyer" data-status="Active" data-created="2026-01-07">
                                    <td>1004</td>
                                    <td class="fw-semibold">Layla Mansour</td>
                                    <td>layla.mansour@legal.ae</td>
                                    <td><span class="badge badge-primary">Lawyer</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-07</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1004)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1004)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1004)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="John Smith" data-email="john.smith@email.com" data-role="User" data-status="Inactive" data-created="2026-01-06">
                                    <td>1005</td>
                                    <td class="fw-semibold">John Smith</td>
                                    <td>john.smith@email.com</td>
                                    <td><span class="badge badge-info">User</span></td>
                                    <td><span class="badge badge-secondary">Inactive</span></td>
                                    <td>2026-01-06</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1005)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1005)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1005)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Omar Abdullah" data-email="omar.abdullah@advocates.ae" data-role="Lawyer" data-status="Active" data-created="2026-01-05">
                                    <td>1006</td>
                                    <td class="fw-semibold">Omar Abdullah</td>
                                    <td>omar.abdullah@advocates.ae</td>
                                    <td><span class="badge badge-primary">Lawyer</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-05</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1006)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1006)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1006)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Fatima Ali" data-email="fatima.ali@email.com" data-role="User" data-status="Active" data-created="2026-01-04">
                                    <td>1007</td>
                                    <td class="fw-semibold">Fatima Ali</td>
                                    <td>fatima.ali@email.com</td>
                                    <td><span class="badge badge-info">User</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-04</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1007)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1007)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1007)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Michael Brown" data-email="michael.brown@email.com" data-role="User" data-status="Suspended" data-created="2026-01-03">
                                    <td>1008</td>
                                    <td class="fw-semibold">Michael Brown</td>
                                    <td>michael.brown@email.com</td>
                                    <td><span class="badge badge-info">User</span></td>
                                    <td><span class="badge badge-danger">Suspended</span></td>
                                    <td>2026-01-03</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1008)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1008)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1008)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Noor Hassan" data-email="noor.hassan@legal.ae" data-role="Lawyer" data-status="Active" data-created="2026-01-02">
                                    <td>1009</td>
                                    <td class="fw-semibold">Noor Hassan</td>
                                    <td>noor.hassan@legal.ae</td>
                                    <td><span class="badge badge-primary">Lawyer</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2026-01-02</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1009)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1009)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1009)" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr data-name="Admin User" data-email="admin@legalqa.com" data-role="Admin" data-status="Active" data-created="2025-12-01">
                                    <td>1010</td>
                                    <td class="fw-semibold">Admin User</td>
                                    <td>admin@legalqa.com</td>
                                    <td><span class="badge badge-secondary">Admin</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>2025-12-01</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-primary btn-icon btn-sm" onclick="viewUser(1010)" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-icon btn-sm" onclick="editUser(1010)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" onclick="deleteUser(1010)" title="Delete" disabled>
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

    <!-- View User Modal -->
    <div class="modal" id="viewUserModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">User Details</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewUserContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Close</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editUserModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Edit User</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- BACKEND: PATCH /admin/users/{id} -->
                <form id="editUserForm">
                    <input type="hidden" name="user_id" id="editUserId">
                    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="User">User</option>
                            <option value="Lawyer">Lawyer</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Cancel</button>
                <button class="btn btn-primary" onclick="saveUser()">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Add New User</h3>
                <button class="modal-close" data-modal-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- BACKEND: POST /admin/users -->
                <form id="addUserForm">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="User">User</option>
                            <option value="Lawyer">Lawyer</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" data-modal-close>Cancel</button>
                <button class="btn btn-primary" onclick="addUser()">Add User</button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script src="{{ asset('assets/js/admin-ui.js') }}"></script>
    <script>
        // Initialize table filter
        const userFilter = new TableFilter('usersTable');
        
        // View user details
        function viewUser(userId) {
            // BACKEND: GET /admin/users/{userId}
            const content = `
                <div class="mb-3">
                    <strong>User ID:</strong> ${userId}
                </div>
                <div class="mb-3">
                    <strong>Name:</strong> Sample User
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> user@example.com
                </div>
                <div class="mb-3">
                    <strong>Role:</strong> <span class="badge badge-info">User</span>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> <span class="badge badge-success">Active</span>
                </div>
                <div class="mb-3">
                    <strong>Created:</strong> 2026-01-10
                </div>
            `;
            document.getElementById('viewUserContent').innerHTML = content;
            Modal.open('viewUserModal');
        }
        
        // Edit user
        function editUser(userId) {
            // BACKEND: GET /admin/users/{userId}
            populateEditForm('editUserForm', {
                user_id: userId,
                name: 'Sample User',
                email: 'user@example.com',
                role: 'User',
                status: 'Active'
            });
            Modal.open('editUserModal');
        }
        
        // Save user changes
        function saveUser() {
            // BACKEND: PATCH /admin/users/{id}
            const formData = getFormData('editUserForm');
            Toast.info('Demo Mode: User update will be connected to PHP backend later.');
            Modal.close('editUserModal');
        }
        
        // Add new user
        function addUser() {
            // BACKEND: POST /admin/users
            const formData = getFormData('addUserForm');
            Toast.info('Demo Mode: User creation will be connected to PHP backend later.');
            Modal.close('addUserModal');
            resetForm('addUserForm');
        }
        
        // Delete user
        function deleteUser(userId) {
            // BACKEND: DELETE /admin/users/{userId}
            confirmAction('Are you sure you want to delete this user? This action cannot be undone.', () => {
                Toast.info('Demo Mode: User deletion will be connected to PHP backend later.');
            });
        }
        
        // Handle sort
        function handleSort(value) {
            const [attr, order] = value.split('-');
            userFilter.sortBy(attr, order);
        }
    </script>
</body>
</html>

