@extends('layouts.student')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <h1 class="h3 mb-0">My Attendance Records</h1>
            <p class="text-muted">History of your presence in classes</p>
        </div>

        @if(session('warning'))
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Status</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th class="pe-4">Absence Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                @php
                                    $student = auth()->user();
                                    $class = $student->schoolClass;
                                    $section = $student->section;
                                    // Try to find a subject taught by this teacher for this class
                                    $subject = \App\Models\Subject::where('class_id', $student->class_id)
                                        ->whereHas('assignments', function ($q) use ($attendance) {
                                            $q->where('teacher_id', $attendance->teacher_id);
                                        })->first();
                                    $subjectName = $subject ? $subject->name : 'N/A';
                                @endphp
                                <tr>
                                    <td class="ps-4">{{ $attendance->date }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $attendance->status === 'present' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $class->name ?? 'N/A' }}</td>
                                    <td>{{ $section->name ?? 'N/A' }}</td>
                                    <td>{{ $subjectName }}</td>
                                    <td class="pe-4">
                                        @if($attendance->status === 'absent')
                                            @if($attendance->absence_reason)
                                                <div class="p-2 bg-light rounded border">
                                                    <p class="mb-1 small text-muted">Reason:</p>
                                                    <p class="mb-1 fw-medium">{{ $attendance->absence_reason }}</p>
                                                    <span
                                                        class="badge {{ $attendance->reason_status === 'approved' ? 'bg-success' : 'bg-warning' }} small">
                                                        {{ ucfirst($attendance->reason_status) }}
                                                    </span>
                                                </div>
                                            @else
                                                <form action="{{ route('student.attendance.submit-reason', $attendance) }}"
                                                    method="POST">
                                                    @csrf
                                                    <textarea name="absence_reason" class="form-control form-control-sm mb-2"
                                                        placeholder="Write absence reason here..." required></textarea>
                                                    <button type="submit" class="btn btn-primary btn-sm">Submit Reason</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-muted small">N/A (Present)</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-muted">No attendance records found.</td>
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