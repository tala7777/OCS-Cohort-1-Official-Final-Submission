@extends('layouts.admin_master')



@section('title', 'User Details - Admin Dashboard')



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
                    <li class="breadcrumb-item"><a href="admin-users.html" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View User</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-1">User Details</h2>
            <p class="text-muted">Detailed view of user account.</p>
        </div>
        <a href="admin-users.html" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i>
            Back to List</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <!-- User Profile Card -->
            <div class="dashboard-card p-5 h-100">
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            class="rounded-circle border border-4 border-light shadow" alt="User Avatar" width="180"
                            height="180" style="object-fit: cover;">
                    </div>
                    <h2 class="fw-bold mb-2">Alice Wonder</h2>
                    <p class="text-muted fs-4 mb-3">Student</p>
                    <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 fs-6">Active
                        Account</span>
                </div>


            </div>
        </div>

        <div class="col-md-8">
            <!-- Detailed Info -->
            <div class="dashboard-card p-5 h-100">
                <h4 class="fw-bold mb-5">Personal Information</h4>

                <div class="row g-5 mb-5">
                    <div class="col-md-6">
                        <label class="text-muted text-uppercase fw-bold small mb-2 d-block">Full Name</label>
                        <p class="fw-bold fs-3 mb-0">Alice Wonder</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted text-uppercase fw-bold small mb-2 d-block">Email
                            Address</label>
                        <p class="fw-bold fs-3 mb-0">alice@example.com</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted text-uppercase fw-bold small mb-2 d-block">Phone Number</label>
                        <p class="fw-bold fs-3 mb-0">+1 (555) 123-4567</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted text-uppercase fw-bold small mb-2 d-block">Joined Date</label>
                        <p class="fw-bold fs-3 mb-0">Jan 12, 2024</p>
                    </div>
                </div>

                <div class="border-top pt-5">
                    <h5 class="fw-bold mb-4">Account Actions</h5>
                    <div class="d-flex gap-3">
                        <button class="btn btn-primary btn-lg px-4"><i class="bi bi-envelope me-2"></i>Send
                            Message</button>
                        <button class="btn btn-outline-danger btn-lg px-4"><i class="bi bi-trash me-2"></i>Delete
                            Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')

    <script>
        const el = document.getElementById("Users");
        el.classList.add("active");
    </script>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection
