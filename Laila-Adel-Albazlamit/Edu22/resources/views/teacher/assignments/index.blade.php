@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Homework</h1>
                <p class="text-muted">Manage assignments and projects</p>
            </div>
            <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Create Homework
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Due Date</th>
                                <th>Submissions</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $assignment->title }}</td>
                                    <td>{{ $assignment->schoolClass->name }}</td>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td class="text-danger">{{ $assignment->due_date }}</td>
                                    <td>0/0</td> <!-- Placeholder for submissions count -->
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('teacher.assignments.edit', $assignment) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('teacher.assignments.destroy', $assignment) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $assignments->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endpush