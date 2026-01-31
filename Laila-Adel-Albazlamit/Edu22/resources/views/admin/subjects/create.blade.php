@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Subjects</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Create New Subject</h1>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('admin.subjects.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Subject Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required autofocus>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="class_id" class="form-label">Class</label>
                                <select name="class_id" id="class_id"
                                    class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.subjects.index') }}" class="btn btn-light border">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Subject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection