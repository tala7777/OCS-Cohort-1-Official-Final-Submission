<div class="row g-0">
    <div class="col-md-5 bg-primary p-5 text-white d-flex flex-column justify-content-center">
        <i class="fas fa-certificate fa-4x mb-4 text-warning"></i>
        <h2 class="fw-bold mb-3">Join the Professional Network</h2>
        <p class="opacity-75">Connect with clients, establish your authority, and help the community with expert legal advice.</p>
        <ul class="list-unstyled small mt-4">
            <li class="mb-2"><i class="fas fa-check-circle me-2 text-warning"></i> Professional Badge</li>
            <li class="mb-2"><i class="fas fa-check-circle me-2 text-warning"></i> Unlimited Articles</li>
            <li><i class="fas fa-check-circle me-2 text-warning"></i> Priority Listing</li>
        </ul>
    </div>
    <div class="col-md-7 p-4 p-md-5">
        <h4 class="fw-bold mb-4">Submit Verification Request</h4>
        
        <form wire:submit.prevent="register">
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Full Professional Name</label>
                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Atty. Jane Smith">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email Address</label>
                <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" placeholder="counsel@firm.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Primary Specialization</label>
                <select wire:model="specialization_id" class="form-select @error('specialization_id') is-invalid @enderror">
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('specialization_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">License / Bar ID</label>
                    <input type="text" wire:model="license_number" class="form-control @error('license_number') is-invalid @enderror" placeholder="BAR-XXXXX">
                    @error('license_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Location (City)</label>
                    <input type="text" wire:model="location" class="form-control @error('location') is-invalid @enderror" placeholder="e.g. Amman">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold">
                    <span wire:loading.remove>Submit for Admin Review</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin me-2"></i>Processing...</span>
                </button>
            </div>
            <p class="text-muted small text-center mt-3 mb-0">By submitting, you agree to our verification terms.</p>
        </form>
    </div>
</div>
