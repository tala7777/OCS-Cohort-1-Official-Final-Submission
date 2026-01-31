@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Gradebook Overview</h1>
            <a href="{{ route('teacher.grades.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Add New Exam Grades
            </a>
        </div>

        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Subject</label>
                        <select class="form-select">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Class</label>
                        <select name="class_id" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Section</label>
                        <select class="form-select">
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive text-center">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light align-middle">
                            <tr>
                                <th class="ps-4 text-start bg-light sticky-start" style="min-width: 200px;">Student Name
                                </th>
                                <th class="small">HW 1<br><span class="text-muted fw-normal">10 pts</span></th>
                                <th class="small">HW 2<br><span class="text-muted fw-normal">10 pts</span></th>
                                <th class="bg-light border-end">Total Assign.<br><span class="fw-bold">20 pts</span></th>
                                <th>Mid-Term<br><span class="text-muted fw-normal">100 pts</span></th>
                                <th>Quiz 1<br><span class="text-muted fw-normal">20 pts</span></th>
                                <th class="bg-primary text-white border-start">Final Grade<br><span
                                        class="fw-normal opacity-75">140 pts</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td class="ps-4 text-start fw-medium sticky-start bg-white">{{ $grade['student_name'] }}
                                    </td>
                                    <td class="text-muted">{{ $grade['hw1'] }}</td>
                                    <td class="text-muted">{{ $grade['hw2'] }}</td>
                                    <td class="fw-bold border-end">{{ $grade['assign_total'] }}</td>
                                    <td>{{ $grade['mid_term'] }}</td>
                                    <td>{{ $grade['quiz1'] }}</td>
                                    <td class="fw-bold fs-5 bg-primary bg-opacity-10 text-primary border-start">
                                        {{ $grade['final_grade'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection