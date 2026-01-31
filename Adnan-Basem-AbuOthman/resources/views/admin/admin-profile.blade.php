@extends('layouts.admin_master')


@section('title', 'Profile - Admin Dashboard')



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


    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">Admin Profile & Settings</h2>
            <p class="text-muted">Manage your account and platform configuration.</p>
        </div>
    </div>


    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <div class="row">
        <div class="col-md-12 ">
            <!-- Admin Profile Card -->
            <div class="dashboard-card p-5 h-100">
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        <img src="https://static.vecteezy.com/system/resources/previews/005/544/718/non_2x/profile-icon-design-free-vector.jpg"
                            class="rounded-circle mb-3 border border-3 border-light shadow-sm" alt="Admin Avatar"
                            width="140" height="140" style="object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Online</span>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $admin->name }}</h3>
                    <p class="text-muted mb-0">Super Administrator</p>
                </div>

                <div class="border-top pt-4">
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase fw-semibold mb-3">Contact
                            Information</label>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded p-3 me-3 text-primary">
                            <i class="bi bi-person fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Full Name</small>
                            <span class="fw-medium fs-5">{{ $admin->name }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded p-3 me-3 text-primary">
                            <i class="bi bi-envelope fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Email Address</small>
                            <span class="fw-medium fs-5">{{ $admin->email }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-5">
                        <div class="bg-light rounded p-3 me-3 text-primary">
                            <i class="bi bi-telephone fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Phone Number</small>
                            <span class="fw-medium fs-5">{{ $admin->phone }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @method('PUT') <a href="{{ route('admin_profile.edit', $admin->id) }}"
                            class="btn btn-primary btn-lg">
                            <i class="bi bi-pencil me-2"></i>Edit Profile Info
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection



@section('js')


    <script>
        const el = document.getElementById("Profile");
        el.classList.add("active");
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
