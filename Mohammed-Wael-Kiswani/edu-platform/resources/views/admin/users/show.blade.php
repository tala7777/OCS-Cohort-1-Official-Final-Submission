@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">User Details</h2>

    <div class="card p-4">
        <div class="d-flex align-items-center mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="user-avatar me-3" alt="User">
            <div>
                <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                <small class="text-muted">ID: #{{ $user->id }}</small>
            </div>
        </div>

        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
        <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $user->updated_at->format('d M Y, H:i') }}</p>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
    </div>
</div>
@endsection
