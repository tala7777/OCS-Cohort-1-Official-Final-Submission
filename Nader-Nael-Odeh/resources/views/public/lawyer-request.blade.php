@extends('layouts.public')

@section('title', 'Become a Verified Lawyer - LegalQ&A')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8">
                <div class="card border-secondary shadow-lg overflow-hidden">
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
                            
                            <!-- FLash Messages -->
                             @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                             @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Full Professional Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Atty. Jane Smith" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="counsel@firm.com" value="{{ old('email') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Password</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Primary Specialization</label>
                                    <select name="specialization_id" class="form-select @error('specialization_id') is-invalid @enderror" required>
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('specialization_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('specialization_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">License / Bar ID</label>
                                        <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" placeholder="BAR-XXXXX" value="{{ old('license_number') }}" required>
                                        @error('license_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-light">Location (City)</label>
                                        <input type="text" name="location" class="form-control bg-dark border-secondary text-white @error('location') is-invalid @enderror" placeholder="e.g. Amman" value="{{ old('location') }}" required>
                                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-light">Professional CV or Resume</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-warning"><i class="fas fa-file-pdf"></i></span>
                                        <input type="file" name="cv" class="form-control bg-dark border-secondary text-white @error('cv') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                                    </div>
                                    <div class="form-text text-muted small mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Please upload your professional resume in PDF or Word format (max 5MB).
                                    </div>
                                    @error('cv') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold">Submit for Admin Review</button>
                                </div>
                                <p class="text-muted small text-center mt-3 mb-0">By submitting, you agree to our verification terms.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
