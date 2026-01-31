@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Attendance History</h1>
            <a href="{{ route('teacher.attendance.create') }}" class="btn btn-primary">
                <i class="bi bi-calendar-check me-2"></i>Mark New Attendance
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Student</th>
                                <th>Class/Section</th>
                                <th>Status</th>
                                <th class="pe-4">Absence Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td class="ps-4">{{ $attendance->date }}</td>
                                    <td class="fw-medium">{{ $attendance->student->name }}</td>
                                    <td>{{ $attendance->student->schoolClass->name ?? 'N/A' }} -
                                        {{ $attendance->student->section->name ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $attendance->status === 'present' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4">
                                        @if($attendance->status === 'absent' && $attendance->absence_reason)
                                            <div class="p-2 bg-light rounded border" style="max-width: 300px;">
                                                <p class="mb-1 fw-medium small">{{ $attendance->absence_reason }}</p>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span class="badge {{ $attendance->reason_status === 'approved' ? 'bg-success' : 'bg-warning' }} small">
                                                        {{ ucfirst($attendance->reason_status) }}
                                                    </span>
                                                    @if($attendance->reason_status === 'pending')
                                                        <form action="{{ route('teacher.attendance.approve-reason', $attendance) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success py-0 px-2" style="font-size: 0.75rem;">Approve</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($attendance->status === 'absent')
                                            <span class="text-muted small">No reason submitted yet</span>
                                        @else
                                            <span class="text-muted small">N/A (Present)</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $attendances->links() }}</div>
    </div>
@endsection