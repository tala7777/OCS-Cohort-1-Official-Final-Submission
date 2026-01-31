@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Manage Sections</h1>
            <a href="{{ route('admin.sections.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Add New Section
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <!-- Search -->
                <div class="mb-4">
                    <form action="{{ route('admin.sections.index') }}" method="GET" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search sections..." class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td>{{ $section->id }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->schoolClass->name }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.sections.edit', $section) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No sections found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $sections->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Are you sure?', text: "You won't be able to revert this!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });
    </script>
@endpush