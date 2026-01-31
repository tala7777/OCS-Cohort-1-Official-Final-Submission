@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" name="role">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (leave empty to keep current)</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-warning">Update User</button>
    </form>
</div>
@endsection
