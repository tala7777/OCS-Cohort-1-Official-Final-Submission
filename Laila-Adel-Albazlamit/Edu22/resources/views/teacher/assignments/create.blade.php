@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <h1 class="h3 mb-0">Create Homework</h1>
            <p class="text-muted">Assign new work to your students</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('teacher.assignments.store') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="title" class="form-label fw-bold">Title</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="e.g. Algebra Problems" value="{{ old('title') }}" required autofocus>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subject_id" class="form-label fw-bold">Subject</label>
                                    <select name="subject_id" id="subject_id"
                                        class="form-select @error('subject_id') is-invalid @enderror" required>
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }} ({{ $subject->schoolClass->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="class_id" class="form-label fw-bold">Class & Section</label>
                                    <select name="class_id" id="class_id"
                                        class="form-select @error('class_id') is-invalid @enderror" required>
                                        <option value="">Select Class</option>
                                        @foreach($schoolClasses as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="due_date" class="form-label fw-bold">Due Date</label>
                                    <input type="date" name="due_date" id="due_date"
                                        class="form-control @error('due_date') is-invalid @enderror"
                                        value="{{ old('due_date') }}" required>
                                    @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Description / Instructions
                                    (Optional)</label>
                                <textarea name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror" rows="5"
                                    placeholder="Enter detailed instructions here...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('teacher.assignments.index') }}" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Assign Homework</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection