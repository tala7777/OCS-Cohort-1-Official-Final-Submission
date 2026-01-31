@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Teacher Dashboard</h1>
                <p class="text-muted">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Create New Assignment
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3">
                            <i class="bi bi-book fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small text-uppercase fw-bold">My Classes</h6>
                            <h4 class="mb-0">5</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success me-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small text-uppercase fw-bold">My Students</h6>
                            <h4 class="mb-0">150</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning me-3">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small text-uppercase fw-bold">Assignments</h6>
                            <h4 class="mb-0">{{ $stats['assignments'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info me-3">
                            <i class="bi bi-calendar-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small text-uppercase fw-bold">Attendance</h6>
                            <h4 class="mb-0">{{ $stats['attendances'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Upcoming Schedule -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">Upcoming Schedule</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 py-3 d-flex align-items-center">
                                <div class="me-3 text-center" style="width: 50px;">
                                    <div class="fw-bold text-primary">09:00</div>
                                    <div class="small text-muted text-uppercase">AM</div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Mathematics - Grade 10A</h6>
                                    <small class="text-muted">Room 302 • Algebra Intro</small>
                                </div>
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Today</span>
                            </div>
                            <div class="list-group-item px-0 py-3 d-flex align-items-center">
                                <div class="me-3 text-center" style="width: 50px;">
                                    <div class="fw-bold text-primary">11:30</div>
                                    <div class="small text-muted text-uppercase">AM</div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Physics - Grade 11B</h6>
                                    <small class="text-muted">Lab 2 • Mechanics Experiment</small>
                                </div>
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Today</span>
                            </div>
                            <div class="list-group-item px-0 py-3 d-flex align-items-center">
                                <div class="me-3 text-center" style="width: 50px;">
                                    <div class="fw-bold text-muted">02:00</div>
                                    <div class="small text-muted text-uppercase">PM</div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-muted">Department Meeting</h6>
                                    <small class="text-muted">Staff Room</small>
                                </div>
                                <span class="badge bg-light text-muted border rounded-pill">Tomorrow</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Subjects -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">My Subjects</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded p-2"><i class="bi bi-calculator"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">Mathematics</h6>
                                <small class="text-muted">Grade 10 • 2 Sections</small>
                            </div>
                            <a href="{{ route('teacher.subjects.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-success text-white rounded p-2"><i class="bi bi-lightning-charge"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">Physics</h6>
                                <small class="text-muted">Grade 11 • 1 Section</small>
                            </div>
                            <a href="{{ route('teacher.subjects.index') }}" class="btn btn-sm btn-outline-success">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection