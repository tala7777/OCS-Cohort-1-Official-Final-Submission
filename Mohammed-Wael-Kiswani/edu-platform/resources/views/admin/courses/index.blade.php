@extends('layouts.app')

@section('title', 'Courses Management')

@section('content')
<!-- Courses Management Page -->
<div id="courses" class="page active">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Courses Management</h2>
            <p class="text-muted mb-0">Create, edit, and manage all courses on the platform</p>
        </div>
        <!-- زر إضافة كورس -->
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Course
        </a>
    </div>
    
    <div class="data-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Course Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>
                        <div class="fw-medium">{{ $course->name }}</div>
                        {{-- إذا بدك تضيف عدد الدروس والساعات لاحقًا --}}
                        {{-- <small class="text-muted">{{ $course->lessons }} lessons • {{ $course->hours }} hours</small> --}}
                    </td>
                    <td>{{ $course->category }}</td>
                    <td class="fw-bold text-primary">${{ $course->price }}</td>
                    <td>
                        <span class="badge bg-success bg-opacity-10 text-success border-0">Published</span>
                        {{-- لاحقًا لو عندك حقل status
                        <span class="badge {{ $course->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                        --}}
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <!-- زر التعديل -->
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- زر الحذف -->
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                               <button class="btn btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this course?')">
                               <i class="fas fa-trash"></i>
                               </button>

     <a href="{{ route('admin.courses.show', $course->id) }}"
   class="btn btn-outline-info">
    <i class="fas fa-eye"></i>
</a>



                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
