<div>
    <!-- Flash Messages (Simple Design) -->
    @if (session()->has('success'))
        <div class="alert simple-alert simple-alert-success m-3" role="alert">
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
        <div class="alert simple-alert simple-alert-danger m-3" role="alert">
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
                                wire:model.live="search"
                            >
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Role</label>
                            <select 
                                class="form-select"
                                id="roleFilter"
                                wire:model.live="roleFilter"
                            >
                                <option value="">All Roles</option>
                                <option value="user">User</option>
                                <option value="lawyer">Lawyer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Filter by Status</label>
                            <select 
                                class="form-select"
                                id="statusFilter"
                                wire:model.live="statusFilter"
                            >
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="form-label">Sort</label>
                            <select 
                                class="form-select"
                                id="sortSelect"
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

                <!-- Users Table -->
                <!-- BACKEND: GET /admin/users -->
                <div class="table-wrapper">
                   
     <div class="table-header">
                        <h3 class="table-title">All Users</h3>
                        <button class="btn btn-primary" wire:click="addUser">
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
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge badge-info">{{ $user->role }}</span></td>
                        <td><span class="badge badge-success">{{ $user->status }}</span></td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-primary btn-icon btn-sm" wire:click="viewUser({{ $user->id }})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-icon btn-sm" wire:click="editUser({{ $user->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-icon btn-sm" wire:click="confirmDelete({{ $user->id }})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-4 py-3 border-top border-white/10 d-flex align-items-center justify-content-between" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="text-muted small">
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
        </div>
        <div class="d-flex align-items-center gap-2">
            @if ($users->onFirstPage())
                <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            @else
                <button wire:click="previousPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            @endif

            <span class="text-muted small mx-2">
                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
            </span>

            @if ($users->hasMorePages())
                <button wire:click="nextPage" class="btn btn-sm btn-outline-light" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            @else
                <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            @endif
        </div>
    </div>

    @if ($isviewopen)
        <div class="modal show" id="viewUserModal" style="display: flex !important; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered" style="margin: 0; max-width: 500px; width: 100%;">
                <div class="modal-header">
                    <h3 class="modal-title">User Details</h3>
                    {{-- Make the X actually close --}}
                    <button type="button" class="modal-close" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body" id="viewUserContent">
                    <div class="mb-3">
                        <strong>User ID:</strong> {{ $selectedUser?->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $selectedUser?->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $selectedUser?->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong> <span class="badge badge-info">{{ $selectedUser?->role }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> <span class="badge badge-success">{{ $selectedUser?->status }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $selectedUser?->created_at }}
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-primary" wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    @endif


    @if ($iseditopen)
        <div class="modal show" id="editUserModal" style="display: flex !important; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;">
h            <div class="modal-dialog modal-dialog-centered" style="margin: 0; max-width: 500px; width: 100%;">
                <div class="modal-header">
                    <h3 class="modal-title">Edit User</h3>
                    <button type="button" class="modal-close" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateUser">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Enter name" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" wire:model="email" placeholder="Enter email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" wire:model="password" placeholder="Enter password(leave it empty if you don't want to change it)" >
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label">Repeat Password</label>
                            <input type="password" class="form-control" wire:model="password_confirmation" placeholder="repeat password (leave it empty if you don't want to change it)" >
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" wire:model="role" placeholder="Select role" required>
                                <option value="user">User</option>
                                <option value="lawyer">Lawyer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" wire:model="status" placeholder="Select status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" wire:click="closeModal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($isaddopen)
    
 <div class="modal show" id="addUserModal" style="display: flex !important; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-header">
                <h3 class="modal-title">Add New User</h3>
                <button class="modal-close" wire:click="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- BACKEND: POST /admin/users -->
                <form wire:submit.prevent="createUser">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" wire:model="name" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" wire:model="email" required>
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" wire:model="password" required>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" wire:model="role" required>
                            <option value="">Select Role</option>
                            <option value="user">User</option>
                            <option value="lawyer">Lawyer</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" wire:model="status" >
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" wire:click="closeModal">Cancel</button>
                <button class="btn btn-primary" wire:click="createUser">Add User</button>
            </div>
        </div>
    </div>



    @endif
</div>
