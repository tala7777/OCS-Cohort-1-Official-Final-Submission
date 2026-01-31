@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container py-4">

    <!-- عنوان الصفحة + زر إضافة جديد -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Users Management</h2>
            <p class="text-muted mb-0">Manage all platform users, roles, and permissions</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New User
        </a>
    </div>

    <!-- رسائل النجاح -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Cards إحصائيات (اختياري) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <p class="card-text">{{ $totalCourses }}</p>
                </div>
            </div>
        </div>
        
    </div>

    <!-- جدول المستخدمين -->
    <div class="data-table">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=128" class="user-avatar me-3" alt="User">
                            <div>
                                <div class="fw-medium">{{ $user->name }}</div>
                                <small class="text-muted">ID: #{{ $user->id }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }} bg-opacity-10 text-{{ $user->role === 'admin' ? 'primary' : 'secondary' }} border-0">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'blocked' ? 'danger' : 'secondary') }} bg-opacity-10 text-{{ $user->status === 'active' ? 'success' : ($user->status === 'blocked' ? 'danger' : 'secondary') }} border-0">
                            {{ ucfirst($user->status ?? 'Active') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(this)">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
function confirmDelete(form) {
    return confirm('Are you sure you want to delete this user?');
}
</script>
@endpush
