@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
<div class="container">
    <h2 class="mb-4">Course Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $course->id }}</p>
            <p><strong>Name:</strong> {{ $course->name }}</p>
            <p><strong>Description:</strong> {{ $course->description }}</p>
            <p><strong>Price:</strong> {{ $course->price }}</p>
            <p><strong>Created At:</strong> {{ $course->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary mt-3">
        Back
    </a>
</div>
@endsection
