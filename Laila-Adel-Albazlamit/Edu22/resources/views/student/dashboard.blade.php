@extends('layouts.student')

@section('content')
    <div class="container-fluid p-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Dashboard</h1>
                <p class="text-muted small">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </header>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted small text-uppercase fw-bold">Overall Attendance</h6>
                        <h2 class="card-title mb-0">{{ $attendancePercentage }}%</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted small text-uppercase fw-bold">Pending Homework</h6>
                        <h2 class="card-title mb-0 text-warning">{{ $pendingHomeworkCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted small text-uppercase fw-bold">Next Class</h6>
                        <h2 class="card-title mb-0">Math</h2>
                        <small class="text-muted">10:00 AM</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Upcoming Assignments</h5>
                        <a href="{{ route('student.assignments.index') }}" class="btn btn-sm btn-outline-primary">View
                            All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Subject</th>
                                        <th>Task</th>
                                        <th>Due Date</th>
                                        <th class="pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingAssignments as $assignment)
                                        <tr>
                                            <td class="ps-4">
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border">{{ $assignment->subject->name }}</span>
                                            </td>
                                            <td class="fw-medium">{{ $assignment->title }}</td>
                                            <td
                                                class="{{ \Carbon\Carbon::parse($assignment->due_date)->isToday() ? 'text-danger' : '' }}">
                                                {{ \Carbon\Carbon::parse($assignment->due_date)->isToday() ? 'Today' : (\Carbon\Carbon::parse($assignment->due_date)->isTomorrow() ? 'Tomorrow' : $assignment->due_date) }}
                                            </td>
                                            <td class="pe-4 text-end">
                                                <a href="#" class="btn btn-sm btn-primary px-3">Submit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-muted">No upcoming assignments.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">Recent Grades</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0 fw-bold">English Essay</h6>
                                    <span class="text-success fw-bold">A</span>
                                </div>
                                <small class="text-muted small text-uppercase">English Literature • Sep 20</small>
                            </div>
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0 fw-bold">History Quiz</h6>
                                    <span class="text-primary fw-bold">B+</span>
                                </div>
                                <small class="text-muted small text-uppercase">World History • Sep 18</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection