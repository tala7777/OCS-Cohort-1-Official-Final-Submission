@extends('layouts.public')

@section('title', 'Dashboard - Legal Q&A')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-secondary shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>My Dashboard</h4>
                </div>
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&size=100&background=random" class="rounded-circle shadow">
                    </div>
                    <h2 class="fw-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted mb-4">Role: <span class="badge bg-secondary">{{ ucfirst(Auth::user()->role ?? 'User') }}</span></p>

                    <div class="d-grid gap-3 d-md-flex justify-content-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Go to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
