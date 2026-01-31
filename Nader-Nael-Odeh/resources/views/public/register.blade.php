@extends('layouts.public')

@section('title', 'LegalQ&A - Register')

@section('styles')
<style>
    .nav-tabs {
        border-bottom-color: var(--border-color);
    }
    .nav-tabs .nav-link {
        color: var(--text-secondary);
        border: none;
        border-bottom: 2px solid transparent;
    }
    .nav-tabs .nav-link:hover {
        color: var(--text-primary);
        border-color: transparent;
    }
    .nav-tabs .nav-link.active {
        background-color: transparent !important;
        color: var(--warning) !important;
        border-bottom: 2px solid var(--warning);
    }
    /* File Input Styling */
    input[type="file"]::file-selector-button {
        background-color: var(--bg-tertiary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
        border-right: 1px solid var(--border-color) !important;
        padding: 0.375rem 0.75rem;
        border-radius: 50rem;
        margin-right: 1rem;
        transition: all 0.2s;
    }
    input[type="file"]::file-selector-button:hover {
        background-color: var(--bg-secondary) !important;
        color: var(--primary) !important;
    }
</style>
@endsection

@section('content')
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Branding Header -->
                <div class="text-center mb-5">
                    <a href="{{ url('/') }}" class="text-decoration-none h2 fw-bold text-white">
                        <i class="fas fa-balance-scale text-warning me-2"></i>LEGAL<span class="text-warning">Q&A</span>
                    </a>
                </div>

                <div class="card shadow-lg border-secondary pb-4 bg-dark">
                    <div class="card-header border-bottom border-secondary bg-transparent p-4">
                        <h4 class="fw-bold text-white mb-0"><i class="fas fa-user me-2 text-primary"></i>User Registration</h4>
                    </div>

                    <div class="card-body p-4 pt-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="role" value="user">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-pill px-4" placeholder="Jane Doe" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="text-danger small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-pill px-4" placeholder="jane@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-white">Password</label>
                                <input type="password" name="password" class="form-control rounded-pill px-4" placeholder="Min 8 characters" required>
                                @error('password')
                                    <span class="text-danger small ms-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-white">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-pill px-4" placeholder="Confirm password" required>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold">Register as User</button>
                            </div>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <a href="{{ route('lawyer-request') }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                <i class="fas fa-gavel me-1"></i> Are you a Lawyer? Register here
                            </a>
                        </div>
                    </div>
                        <div class="text-center border-top border-secondary pt-4">
                            <p class="small text-muted mb-0">Already have an account? <a href="{{ url('/login') }}" class="text-warning text-decoration-none">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
