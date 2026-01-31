@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.subjects.index') }}"
                            class="text-decoration-none">My Subjects</a></li>
                    <li class="breadcrumb-item active">{{ $subject->name }} ({{ $subject->schoolClass->name }})</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h3 mb-0">{{ $subject->name }}</h1>
                    <p class="text-muted">{{ $subject->schoolClass->name }} • {{ count($students) }} Students</p>
                </div>
                <a href="{{ route('teacher.attendance.create', ['class_id' => $subject->class_id]) }}"
                    class="btn btn-primary">
                    <i class="bi bi-calendar-check me-2"></i>Take Attendance
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="subjectTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                    type="button" role="tab">Students</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments"
                    type="button" role="tab">Assignments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button"
                    role="tab">Attendance</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button"
                    role="tab">Grades</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Students Tab -->
            <div class="tab-pane fade show active" id="students" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Student Name</th>
                                        <th>Roll No.</th>
                                        <th>Attendance Rate</th>
                                        <th class="pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td class="ps-4 fw-medium">{{ $student->name }}</td>
                                            <td>{{ $student->id }}</td>
                                            <td><span class="badge bg-success">95%</span></td>
                                            <td class="pe-4 text-end"><button class="btn btn-sm btn-outline-primary">View
                                                    Profile</button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-muted">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments Tab -->
            <div class="tab-pane fade" id="assignments" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('teacher.assignments.create', ['class_id' => $subject->class_id, 'subject_id' => $subject->id]) }}"
                        class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Create Assignment
                    </a>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Title</th>
                                        <th>Due Date</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th class="pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignments as $assignment)
                                        <tr>
                                            <td class="ps-4 fw-medium">{{ $assignment->title }}</td>
                                            <td class="text-danger">{{ $assignment->due_date }}</td>
                                            <td>0/{{ count($students) }}</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td class="pe-4 text-end">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-sm btn-info text-white me-1">Submissions</a>
                                                    <button class="btn btn-sm btn-outline-danger"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-4 text-center text-muted">No assignments created yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Tab -->
            <div class="tab-pane fade" id="attendance" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 text-center">
                            <h6 class="text-muted small text-uppercase">Average Attendance</h6>
                            <h3 class="mb-0 text-primary">{{ $attendanceRate }}%</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 text-center">
                            <h6 class="text-muted small text-uppercase">Present Today</h6>
                            <h3 class="mb-0 text-success">{{ $todayPresent }}/{{ count($students) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grades Tab -->
            <div class="tab-pane fade" id="grades" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('teacher.grades.index') }}" class="btn btn-outline-primary">Open Full Gradebook</a>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Student</th>
                                        <th>Mid-term</th>
                                        <th>Finals</th>
                                        <th class="pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td class="ps-4 fw-medium">{{ $student->name }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td class="pe-4 fw-bold">-</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-muted">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection