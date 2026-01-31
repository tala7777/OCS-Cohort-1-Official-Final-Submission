@extends('layouts.student')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <h1 class="h3 mb-0">My Assignments</h1>
            <p class="text-muted">View and manage your homework</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Teacher</th>
                                <th>Subject</th>
                                <th class="pe-4">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $assignment->title }}</td>
                                    <td>{{ $assignment->teacher->name }}</td>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td class="pe-4 text-danger">{{ $assignment->due_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-muted">No assignments assigned yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $assignments->links() }}</div>
    </div>
@endsection