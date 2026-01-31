@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div id="main-content">

    <!-- Top Navbar (اختياري إذا حاب تظهر) -->
    <div id="top-navbar">
        <div class="navbar-brand">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </div>
        

         <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
    </div>

    <div class="page-content container-fluid py-4">


        <h2 class="fw-bold mb-3 page-header">Dashboard Overview</h2>

        <!-- Stat Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <div class="card-body">
                        <div class="stat-title">Total Users</div>
                        <div class="stat-number">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <div class="card-body">
                        <div class="stat-title">Total Courses</div>
                        <div class="stat-number">{{ $totalCourses }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <div class="card-body">
                        <div class="stat-title">Total Lessons</div>
                        <div class="stat-number">{{ $totalLessons }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card text-center">
                    <div class="card-body">
                        <div class="stat-title">Total Revenue</div>
                        <div class="stat-number">${{ $totalRevenue }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <div class="stat-title mb-2">Users Growth</div>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <div class="stat-title mb-2">Revenue Overview</div>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
