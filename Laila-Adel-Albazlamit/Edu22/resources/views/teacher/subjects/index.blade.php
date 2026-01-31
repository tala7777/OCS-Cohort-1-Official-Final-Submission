@extends('layouts.teacher')

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h3 mb-4">My Subjects</h1>

        <div class="row g-4">
            @forelse($subjects as $subject)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-calculator fs-3 text-primary"></i>
                                </div>
                                <span class="badge bg-light text-dark border">
                                    {{ $subject->schoolClass->name }} -
                                    {{ $subject->schoolClass->sections->first()->name ?? 'A' }}
                                </span>
                            </div>
                            <h5 class="card-title fw-bold">{{ $subject->name }}</h5>
                            <p class="text-muted small">Daily • 09:00 AM - 10:00 AM</p>
                            <div class="d-grid shadow-sm">
                                <a href="{{ route('teacher.subjects.show', $subject->id) }}"
                                    class="btn btn-outline-primary">Manage Class</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No subjects assigned yet.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $subjects->links() }}
        </div>
    </div>
@endsection