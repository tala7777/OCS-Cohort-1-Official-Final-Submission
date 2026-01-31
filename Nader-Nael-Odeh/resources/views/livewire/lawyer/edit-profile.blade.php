<div>
    <form wire:submit.prevent="saveProfile">
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Sidebar: Avatar & Contact -->
            <div class="col-lg-4">
                <!-- Avatar Card -->
                <div class="card border-secondary shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="position-relative d-inline-block mb-3">
                            @if ($profile_picture)
                                <img src="{{ $profile_picture->temporaryUrl() }}" 
                                     class="rounded-circle border border-4 border-primary shadow" 
                                     style="width: 150px; height: 150px; object-fit: cover;" 
                                     alt="Profile Picture">
                            @elseif($existing_profile_picture)
                                <img src="{{ asset('storage/' . $existing_profile_picture) }}" 
                                     class="rounded-circle border border-4 border-primary shadow" 
                                      style="width: 150px; height: 150px; object-fit: cover;" 
                                     alt="Profile Picture">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($full_name) }}&background=0d6efd&color=fff&size=150" 
                                     class="rounded-circle border border-4 border-primary shadow" 
                                      style="width: 150px; height: 150px; object-fit: cover;" 
                                     alt="Profile Picture">
                            @endif

                            <label for="profilePicInput" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 mb-1 me-1 shadow-sm" style="width: 35px; height: 35px; padding-top: 6px;">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="profilePicInput" wire:model="profile_picture" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                        </div>

                        <h5 class="fw-bold mb-1">{{ $full_name }}</h5>
                        <p class="text-muted small mb-3">{{ $email }}</p>

                        <div class="d-grid gap-2">
                             <div wire:loading wire:target="profile_picture" class="text-primary small"><i class="fas fa-spinner fa-spin me-1"></i>Uploading...</div>
                            @if($existing_profile_picture || $profile_picture)
                                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removePhoto">
                                    <i class="fas fa-trash me-2"></i>Remove Photo
                                </button>
                            @endif
                        </div>
                        @error('profile_picture') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div class="card border-secondary shadow-sm">
                    <div class="card-header bg-transparent border-secondary fw-bold">
                        <i class="fas fa-address-card me-2 text-primary"></i>Contact Info
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Location</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary"><i class="fas fa-map-marker-alt fa-fw"></i></span>
                                <input type="text" class="form-control" wire:model="location" placeholder="e.g. Riyadh">
                            </div>
                            @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary"><i class="fas fa-phone fa-fw"></i></span>
                                <input type="text" class="form-control" wire:model="phone" placeholder="+966...">
                            </div>
                            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary"><i class="fab fa-whatsapp fa-fw"></i></span>
                                <input type="text" class="form-control" wire:model="whatsapp_number" placeholder="+966...">
                            </div>
                            @error('whatsapp_number') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small text-muted text-uppercase fw-bold">LinkedIn</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary"><i class="fab fa-linkedin-in fa-fw"></i></span>
                                <input type="url" class="form-control" wire:model="linkedin_profile" placeholder="https://linkedin.com/...">
                            </div>
                            @error('linkedin_profile') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header border-secondary bg-transparent p-4">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2 text-primary"></i>Main Profile Details</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Display Name</label>
                            <input type="text" class="form-control form-control-lg" wire:model="full_name" required>
                            @error('full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Professional Bio</label>
                            <textarea class="form-control" wire:model="bio" rows="5" required placeholder="Tell clients about your experience and expertise..."></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Maximum 500 characters</small>
                                <small class="text-muted" x-data="{ count: 0 }" x-init="$watch('$wire.bio', value => count = value ? value.length : 0)" x-text="count + '/500'"></small>
                            </div>
                            @error('bio') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                   
                        <div class="mb-4">
                             <label class="form-label fw-bold mb-3 d-block">Specializations <span class="text-danger">*</span></label>
                            
                            <div class="specialization-grid">
                                <style>
                                    .spec-checkbox:checked + .spec-card {
                                        border-color: var(--bs-primary) !important;
                                        background-color: rgba(13, 110, 253, 0.1);
                                        box-shadow: 0 0 0 1px var(--bs-primary);
                                    }
                                    .spec-checkbox:checked + .spec-card .spec-icon {
                                        color: var(--bs-primary) !important;
                                        opacity: 1 !important;
                                    }
                                    .spec-checkbox:checked + .spec-card .check-indicator {
                                        opacity: 1;
                                        transform: scale(1);
                                    }
                                    .spec-card:hover {
                                        border-color: var(--bs-gray-600);
                                        background-color: var(--bs-dark);
                                    }
                                    .check-indicator {
                                        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                                        opacity: 0;
                                        transform: scale(0.5);
                                    }
                                </style>

                                <div class="row g-3">
                                    @foreach($categories as $category)
                                        <div class="col-md-6">
                                            <input type="checkbox" class="spec-checkbox d-none" id="cat_{{$category->id}}" value="{{$category->id}}" wire:model="specializations">
                                            
                                            <label class="spec-card d-flex align-items-center p-3 border border-secondary rounded-3 cursor-pointer h-100 position-relative transition-all bg-dark" for="cat_{{$category->id}}">
                                                <div class="spec-icon text-secondary me-3 transition-all opacity-50">
                                                    <i class="fas fa-gavel fa-lg"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block text-white small">{{ $category->name }}</span>
                                                </div>
                                                <div class="check-indicator text-primary position-absolute top-50 end-0 translate-middle-y me-3">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 border-top border-secondary pt-2">
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Select all applicable areas</small>
                                <div class="text-end">
                                    <span class="badge bg-secondary" x-data="{ count: {{ count($specializations) }} }" x-init="$watch('$wire.specializations', value => count = value.length)" x-text="count + ' Selected'"></span>
                                </div>
                            </div>
                            @error('specializations') <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top border-secondary">
                            <a href="{{ route('lawyer.dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="fas fa-save me-2"></i>Save Final Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </form>

    
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('profile-updated', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
</div>
