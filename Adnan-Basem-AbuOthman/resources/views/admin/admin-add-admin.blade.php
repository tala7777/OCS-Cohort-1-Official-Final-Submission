@extends('layouts.admin_master')



@section('title', 'Add Admin - Admin Dashboard')


@section('head')


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .sidebar {
            background-color: #0F172A;
        }
    </style>


@endsection



@section('content')

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admins.index')}}" class="text-decoration-none">Admins</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-1">Add New Admin</h2>
            <p class="text-muted">Invite a new administrator to the platform.</p>
        </div>
    </div>


    @error('name')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    @error('email')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    @error('phone')
        <p class="text-danger">{{ $message }}</p>
    @enderror

    @error('password')
        <p class="text-danger">{{ $message }}</p>
    @enderror

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="dashboard-card p-5 h-100">

                <form action="{{ route('admins.store') }}" method="POST">

                    @csrf

                    <h5 class="fw-bold mb-4">Admin Information</h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            placeholder="e.g. John Doe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            placeholder="e.g. john@sakan.app" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="tel" name="phone" class="form-control form-control-lg" placeholder="07" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder=" "
                            required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Add Admin</button>
                        <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>



@endsection




@section('js')



    <script>
        const el = document.getElementById("Admins");
        el.classList.add("active");
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection
