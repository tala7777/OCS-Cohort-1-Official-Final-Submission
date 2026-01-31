<div>
    <!-- Flash Messages -->
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

    <!-- Info Card -->
    <div class="card mb-4" style="border-left: 4px solid var(--info); background: rgba(37, 130, 246, 0.05);">
        <div class="card-body py-3">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-info-circle text-info"></i>
                <p class="mb-0 text-secondary small">
                    Categories are shared across the platform. Deactivate categories to hide them while preserving historical data.
                </p>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="table-wrapper shadow-lg">
        <div class="table-header d-flex justify-content-between align-items-center bg-secondary py-3 px-4 border-bottom border-secondary">
            <h3 class="table-title mb-0">Platform Categories</h3>
            <button class="btn btn-primary px-4 fw-bold shadow-sm" wire:click="openAddModal">
                <i class="fas fa-plus me-2"></i> Add Category
            </button>
        </div>
        <div class="table-container">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Category Name</th>
                        <th>Status</th>
                        <th class="text-center">Questions</th>
                        <th class="text-center">Lawyers</th>
                        <th class="text-center">Articles</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr wire:key="category-{{ $category->id }}">
                        <td class="ps-4 py-3">
                            <span class="fw-bold text-white">{{ $category->name }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $category->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-soft-primary px-3">{{ $category->questions_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-soft-warning px-3">{{ $category->lawyers_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-soft-success px-3">{{ $category->articles_count }}</span>
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-icon border border-secondary" wire:click="editCategory({{ $category->id }})" title="Edit">
                                    <i class="fas fa-edit text-warning"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-icon border border-secondary" 
                                        onclick="confirmCategoryAction('Are you sure you want to {{ $category->status === 'active' ? 'deactivate' : 'activate' }} this category?', () => @this.toggleCategory({{ $category->id }}, '{{ $category->status === 'active' ? 'inactive' : 'active' }}'))" 
                                        title="{{ $category->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $category->status === 'active' ? 'fa-ban text-danger' : 'fa-check text-success' }}"></i>
                                </button>

                                <button class="btn btn-sm btn-icon border border-secondary" 
                                        onclick="confirmCategoryAction('Delete this category? This cannot be undone.', () => @this.deleteCategory({{ $category->id }}))" 
                                        title="Delete">
                                    <i class="fas fa-trash text-muted hover-red"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="opacity-50">
                                <i class="fas fa-tags fa-3x mb-3"></i>
                                <p class="mb-0">No categories found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    @if($showAddModal)
    <div class="modal show" style="display: flex !important; background: rgba(0,0,0,0.8); z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content border-secondary shadow-lg" style="background: #1e293b; border-radius: 12px;">
                <div class="modal-header border-bottom border-white/10 px-4 py-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fas fa-plus-circle text-primary me-2"></i> Add New Category</h5>
                    <button class="modal-close" wire:click="closeAddModal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold mb-2">Category Name</label>
                        <input type="text" class="form-control p-3 bg-primary-navy border-secondary text-white" placeholder="e.g. Environmental Law" wire:model="addCategoryName">
                        @error('addCategoryName') <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label text-secondary fw-semibold mb-2">Initial Status</label>
                        <select class="form-select p-3 bg-primary-navy border-secondary text-white" wire:model="addCategoryStatus">
                            <option value="active">Active (Visible to users)</option>
                            <option value="inactive">Inactive (Hidden)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top border-white/10 px-4 py-3">
                    <button type="button" class="btn btn-link text-white/50 text-decoration-none px-4" wire:click="closeAddModal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4 fw-bold" wire:click="addCategory">
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
    <div class="modal show" style="display: flex !important; background: rgba(0,0,0,0.8); z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content border-secondary shadow-lg" style="background: #1e293b; border-radius: 12px;">
                <div class="modal-header border-bottom border-white/10 px-4 py-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fas fa-edit text-warning me-2"></i> Edit Category</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeEditModal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold mb-2">Category Name</label>
                        <input type="text" class="form-control p-3 bg-primary-navy border-secondary text-white" wire:model="editCategoryName">
                        @error('editCategoryName') <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label text-secondary fw-semibold mb-2">Status</label>
                        <select class="form-select p-3 bg-primary-navy border-secondary text-white" wire:model="editCategoryStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top border-white/10 px-4 py-3">
                    <button type="button" class="btn btn-link text-white/50 text-decoration-none px-4" wire:click="closeEditModal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4 fw-bold" wire:click="updateCategory">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced Script -->
    <script>
        function confirmCategoryAction(message, action) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                background: '#1e293b',
                color: '#e5e7eb',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    action();
                }
            });
        }
    </script>
</div>
