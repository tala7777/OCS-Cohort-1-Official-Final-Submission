@extends('layouts.app')

@section('title', 'Lessons / Videos Management')

@section('content')

<div class="wrapper">
    
    <!-- Main Content -->
    <div id="content" style="margin-left: 0%">
        <div id="lessons" class="page py-5 active">
            <div class="container-fluid px-4">
                <h2 class="fw-bold mb-4" >Lessons / Videos Management</h2>

                <div class="row g-4">
                    <!-- Left Column: Lessons List -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Lessons List</h5>
                                <div class="w-50">
                                    <select class="form-select form-select-sm" onchange="filterCourse(this.value)">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($lessons->count() == 0)
                                    <p class="text-center p-4 text-muted">No lessons added yet.</p>
                                @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Lesson Title</th>
                                                <th>Course</th>
                                                <th>Video</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lessons as $lesson)
                                            <tr data-course="{{ $lesson->course_id }}">
                                                <td>
                                                    <div class="fw-medium">{{ $lesson->title }}</div>
                                                    <small class="text-muted">Lesson • {{ $lesson->course->name }}</small>
                                                </td>
                                                <td>{{ $lesson->course->name }}</td>
                                                <td>
                                                     <video width="320" controls>
                                                     <source src="{{ asset('storage/'.$lesson->video_path) }}" type="video/mp4">
                                                    </video>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Upload New Lesson -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 p-4 h-100">
                            <h5 class="fw-bold mb-4">Upload New Lesson</h5>

                            <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Select Course</label>
                                    <select name="course_id" class="form-select" required>
                                        <option value="">Choose a course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lesson Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter lesson title" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lesson Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Enter lesson description"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Upload Video</label>
                                    <div class="border rounded p-3 text-center bg-light">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                        <p class="text-muted mb-2">Drag & drop video or click to browse</p>
                                        <input type="file" name="video" class="form-control" accept="video/*" required>
                                        <small class="text-muted">Max size: 2GB. Formats: MP4, MOV, AVI</small>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-upload me-2"></i> Upload Lesson
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterCourse(courseId) {
    let rows = document.querySelectorAll('table tbody tr[data-course]');
    rows.forEach(row => {
        row.style.display = (courseId === "" || row.dataset.course == courseId) ? '' : 'none';
    });
}
</script>
@endpush

@endsection
