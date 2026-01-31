@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container">
    <h2>Create New Course</h2>

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Course Name -->
        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Instructor -->
        <div class="mb-3">
            <label class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" value="{{ old('instructor') }}">
            @error('instructor')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Course Image -->
        <div class="mb-3">
            <label class="form-label">Course Image</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
