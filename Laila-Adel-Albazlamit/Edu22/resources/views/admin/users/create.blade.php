@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Create New User</h1>
        </div>

        <div class="card border-0 shadow-sm col-lg-8">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                                autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required
                            onchange="toggleStudentFields()">
                            <option value="teacher" {{ old('role', request('role')) == 'teacher' ? 'selected' : '' }}>Teacher
                            </option>
                            <option value="student" {{ old('role', request('role')) == 'student' ? 'selected' : '' }}>Student
                            </option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div id="student_fields" class="{{ old('role') == 'student' ? '' : 'd-none' }}">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label">Class</label>
                                <select name="class_id" id="class_id"
                                    class="form-select @error('class_id') is-invalid @enderror" onchange="loadSections()">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="section_id" class="form-label">Section</label>
                                <select name="section_id" id="section_id"
                                    class="form-select @error('section_id') is-invalid @enderror">
                                    <option value="">Select Section</option>
                                </select>
                                @error('section_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleStudentFields() {
            const role = document.getElementById('role').value;
            const fields = document.getElementById('student_fields');
            if (role === 'student') {
                fields.classList.remove('d-none');
            } else {
                fields.classList.add('d-none');
            }
        }

        async function loadSections() {
            const classId = document.getElementById('class_id').value;
            const sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (!classId) return;

            try {
                const response = await fetch(`/admin/get-sections/${classId}`);
                const sections = await response.json();
                sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    sectionSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading sections:', error);
            }
        }

        // Initialize if student role selected on load
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('role').value === 'student' && document.getElementById('class_id').value) {
                loadSections();
            }
        });
    </script>
@endpush