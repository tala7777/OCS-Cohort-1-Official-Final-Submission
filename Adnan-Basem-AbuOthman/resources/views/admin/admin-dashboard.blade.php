@extends('layouts.admin_master')

@section('title', 'Admin Dashboard - Sakan')



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

        /* Darker sidebar for Admin */
    </style>


@endsection

@section('activation', 'active')




@section('content')


    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Admin Dashboard</h2>
            <p class="text-muted">Platform overview and management.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stats-card h-100">
                <div class="stats-icon blue"><i class="bi bi-people-fill"></i></div>
                <div class="stats-info flex-grow-1">
                    <h3>{{ $totalUsers }}</h3>
                    <p class="mb-1">Total Users</p>
                    <div class="d-flex justify-content-between small text-muted border-top pt-1 mt-1">
                        <span>{{ $totalStudents }} Students</span>
                        <span>{{ $totalOwners }} Owners</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <div class="stats-icon text-white" style="background-color: #8B5CF6;"><i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $totalUniversities }}</h3>
                    <p>Universities</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <div class="stats-icon orange"><i class="bi bi-house-door-fill"></i></div>
                <div class="stats-info">
                    <h3>{{ $totalApartments }}</h3>
                    <p>Apartments</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card h-100">
                <div class="stats-icon green"><i class="bi bi-currency-dollar"></i></div>
                <div class="stats-info">
                    <h3>{{ $totalRevenue }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5>Recent Users</h5>
            <a class="text-dark" href="{{ route('users.index') }}"><button class="btn btn-sm btn-light">View
                    All</button></a>

        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>

                            @switch($user->role)
                                @case('admin')
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger">{{ $user->role }}</span></td>
                                @break

                                @case('owner')
                                    <td><span class="badge bg-warning bg-opacity-10 text-warning">{{ $user->role }}</span></td>
                                @break

                                @case('student')
                                    <td><span class="badge bg-info bg-opacity-10 text-info">{{ $user->role }}</span></td>
                                @break
                            @endswitch


                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No Users yet.
                                </td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Listings -->
        <div class="dashboard-card">
            <div class="card-header">
                <h5>New Apartment Listings</h5>

                <a class="text-dark" href="{{ route('apartments.index') }}"><button class="btn btn-sm btn-light">View
                        All</button></a>

            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Owner</th>
                            <th>Price</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($apartments as $apart)
                            @php
                                // Find the image marked as 'is_main'
                                $mainImage = $apart->images->where('is_main', true)->first();
                                // Fallback to the first image if no 'is_main' is found
                                $displayImage = $mainImage ?? $apart->images->first();
                            @endphp


                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $displayImage ? asset('storage/' . $displayImage->image_path) : asset('images/sample1.jpg') }}"
                                            class="rounded" width="40" height="40" style="object-fit: cover;">
                                        <span class="fw-bold small">{{ $apart->name }}</span>
                                    </div>
                                </td>



                                <td>{{ $apart->owner->name }}</td>


                                @if ($apart->rent_type == 'whole')
                                    <td>${{ $apart->price }} / full apartment</td>
                                @else($apart->rent_type == 'rooms')
                                    <td>{{ $apart->price }}/room</td>
                                @endif




                                <td>{{ $apart->created_at->diffForHumans() }}</td>
                            </tr>


                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No Apartments yet.
                                </td>
                            </tr>


                        @endforelse









                    </tbody>
                </table>
            </div>
        </div>

    @endsection



    @section('js')

        <script>
            const el = document.getElementById("Overview");
            el.classList.add("active");
        </script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @endsection
