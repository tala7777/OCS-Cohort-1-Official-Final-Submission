@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h1 class="h3 mb-0">Daily Attendance</h1>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" onclick="resetAttendance()">Reset All</button>
                <button type="button" class="btn btn-primary" onclick="markAllPresent()">Mark All Present</button>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Total</h6>
                        <h3 class="mb-0">{{ !empty($students) ? count($students) : 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center h-100 border-bottom border-success border-4">
                    <div class="card-body">
                        <h6 class="text-success small text-uppercase fw-bold">Present</h6>
                        <h3 class="mb-0 text-success" id="count-present">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center h-100 border-bottom border-danger border-4">
                    <div class="card-body">
                        <h6 class="text-danger small text-uppercase fw-bold">Absent</h6>
                        <h3 class="mb-0 text-danger" id="count-absent">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center h-100 border-bottom border-warning border-4">
                    <div class="card-body">
                        <h6 class="text-warning small text-uppercase fw-bold">Review</h6>
                        <h3 class="mb-0 text-warning" id="count-late">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('teacher.attendance.create') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}"
                            onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Class</label>
                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}" {{ $class_id == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">Section</label>
                        <select name="section_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $section_id == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Load Class</button>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($students) && count($students) > 0)
            <form action="{{ route('teacher.attendance.mark') }}" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Student</th>
                                        <th class="text-center text-success" style="width: 120px;">Present</th>
                                        <th class="text-center text-danger pe-4" style="width: 120px;">Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light text-dark border rounded-circle d-flex align-items-center justify-content-center me-3"
                                                        style="width: 35px; height: 35px;">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                    <span class="fw-medium">{{ $student->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio border-2 border-success"
                                                    type="radio" name="attendance[{{ $student->id }}]" value="present" {{ $student->attendance_status == 'present' ? 'checked' : '' }} required>
                                            </td>
                                            <td class="text-center pe-4">
                                                <input class="form-check-input attendance-radio border-2 border-danger" type="radio"
                                                    name="attendance[{{ $student->id }}]" value="absent" {{ $student->attendance_status == 'absent' ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top p-3 text-end">
                        <button class="btn btn-primary px-4">Save Attendance</button>
                    </div>
                </div>
            </form>
        @elseif($class_id && $section_id)
            <div class="alert alert-warning">No students found in this class/section.</div>
        @else
            <div class="alert alert-info">Please select a Class and Section to load the student list.</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function markAllPresent() {
            document.querySelectorAll('input[value="present"]').forEach(r => {
                r.checked = true;
                r.dispatchEvent(new Event('change'));
            });
        }

        function resetAttendance() {
            document.querySelectorAll('input[type="radio"]').forEach(r => {
                r.checked = false;
                r.dispatchEvent(new Event('change'));
            });
        }

        function updateStats() {
            const present = document.querySelectorAll('input[value="present"]:checked').length;
            const absent = document.querySelectorAll('input[value="absent"]:checked').length;

            const presentEl = document.getElementById('count-present');
            const absentEl = document.getElementById('count-absent');

            if (presentEl) presentEl.innerText = present;
            if (absentEl) absentEl.innerText = absent;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.attendance-radio').forEach(radio => {
                radio.addEventListener('change', updateStats);
            });
            updateStats();
        });
    </script>
@endpush