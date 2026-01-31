@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.grades.index') }}">Gradebook</a></li>
                    <li class="breadcrumb-item active">Add Exam Grades</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Add New Exam/Assessment</h1>
        </div>

        <form action="{{ route('teacher.grades.store') }}" method="POST" id="examForm">
            @csrf
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">1. Exam Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Midterm 1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Type</label>
                            <select name="type" class="form-select">
                                <option>Exam</option>
                                <option>Quiz</option>
                                <option>Test</option>
                                <option>Project</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Max Grade <span class="text-danger">*</span></label>
                            <input type="number" name="max_grade" class="form-control" placeholder="100" id="maxGrade"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Subject</label>
                            <select name="subject_id" class="form-select">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Class</label>
                            <select name="class_id" class="form-select">
                                @foreach($schoolClasses as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Section</label>
                            <select name="section_id" class="form-select">
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">2. Enter Student Grades</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" style="width: 5%;">#</th>
                                    <th style="width: 40%;">Student Name</th>
                                    <th style="width: 25%;">Grade Obtained</th>
                                    <th class="pe-4">Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $student->name }}</td>
                                        <td>
                                            <input type="number" name="grades[{{ $student->id }}]"
                                                class="form-control grade-input" placeholder="0 - 100">
                                        </td>
                                        <td class="pe-4">
                                            <input type="text" name="feedback[{{ $student->id }}]"
                                                class="form-control form-control-sm" placeholder="Optional">
                                        </td>
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

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('teacher.grades.index') }}" class="btn btn-light border">Cancel</a>
                <button type="button" class="btn btn-primary px-4" id="saveExamBtn">Save Exam Grades</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const saveBtn = document.getElementById('saveExamBtn');
            const form = document.getElementById('examForm');
            const maxGradeInput = document.getElementById('maxGrade');
            const gradeInputs = document.querySelectorAll('.grade-input');

            saveBtn.addEventListener('click', () => {
                let isValid = true;
                const max = parseFloat(maxGradeInput.value) || 100;

                gradeInputs.forEach(input => {
                    const val = parseFloat(input.value);
                    if (val > max) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (isValid) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saving...',
                        timer: 1000,
                        showConfirmButton: false,
                        didClose: () => form.submit()
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Some grades exceed the maximum allowed score.'
                    });
                }
            });
        });
    </script>
@endpush