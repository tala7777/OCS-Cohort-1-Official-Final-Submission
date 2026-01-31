@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h3 mb-4">Admin Dashboard</h1>

        <div class="row g-4">
            <!-- Teachers Count -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Teachers</h6>
                        <h2 class="mb-0">{{ $stats['teachers'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Students Count -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Students</h6>
                        <h2 class="mb-0">{{ $stats['students'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Classes Count -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Classes</h6>
                        <h2 class="mb-0">{{ $stats['classes'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Subjects Count -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Subjects</h6>
                        <h2 class="mb-0">{{ $stats['subjects'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">Quick Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded d-flex align-items-center gap-3 position-relative">
                                    <div class="bg-primary text-white rounded p-2">
                                        <i class="bi bi-person-plus fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Add New Student</h6>
                                        <a href="{{ route('admin.users.create', ['role' => 'student']) }}"
                                            class="btn btn-sm btn-outline-primary stretched-link">Create Profile</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded d-flex align-items-center gap-3 position-relative">
                                    <div class="bg-info text-white rounded p-2">
                                        <i class="bi bi-person-plus-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Add New Teacher</h6>
                                        <a href="{{ route('admin.users.create', ['role' => 'teacher']) }}"
                                            class="btn btn-sm btn-outline-info stretched-link">Create Profile</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded d-flex align-items-center gap-3 position-relative">
                                    <div class="bg-warning text-white rounded p-2">
                                        <i class="bi bi-building-add fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Create Class</h6>
                                        <a href="{{ route('admin.classes.index') }}"
                                            class="btn btn-sm btn-outline-warning stretched-link">Setup Class</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded d-flex align-items-center gap-3 position-relative">
                                    <div class="bg-success text-white rounded p-2">
                                        <i class="bi bi-journal-plus fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Add Subject</h6>
                                        <a href="{{ route('admin.subjects.index') }}"
                                            class="btn btn-sm btn-outline-success stretched-link">Create Subject</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">System Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div
                                class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent">
                                <div>
                                    <span class="d-block fw-bold">Academic Year</span>
                                    <span class="text-muted small">2024-2025</span>
                                </div>
                                <span class="badge bg-success">Active</span>
                            </div>
                            <div
                                class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent">
                                <div>
                                    <span class="d-block fw-bold">Current Term</span>
                                    <span class="text-muted small">Term 1</span>
                                </div>
                                <span class="badge bg-primary">Running</span>
                            </div>
                            <div
                                class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent">
                                <div>
                                    <span class="d-block fw-bold">Last Backup</span>
                                    <span class="text-muted small">Today, {{ now()->format('h:i A') }}</span>
                                </div>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.academic-year.promote') }}">
    @csrf
    <button class="btn btn-danger"
        onclick="return confirm('Are you sure you want to end the academic year?')">
        End Academic Year & Promote Students
    </button>
</form>
    </div>
@endsection