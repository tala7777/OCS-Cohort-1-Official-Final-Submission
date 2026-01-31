@extends('layouts.owner_master')


@section('title', 'Owner Dashboard - Sakan')


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




@endsection



@section('content')
    @use('App\Models\Apartment')

    @php
        $username = Auth::user()->name;
    @endphp

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Welcome back, {{ $username }}</h2>
            <p class="text-muted">Here's what's happening with your properties today.</p>
        </div>
        <button class="d-lg-none btn btn-primary"><i class="bi bi-list"></i> Menu</button>

    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon blue"><i class="bi bi-building"></i></div>
                <div class="stats-info">
                    <h3>{{ $apartments_num }}</h3>
                    <p>Active Apartments</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon orange"><i class="bi bi-eye"></i></div>
                <div class="stats-info">
                    <h3>{{ $totalViews }}</h3>
                    <p>Total Views</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon green"><i class="bi bi-chat-text"></i></div>
                <div class="stats-info">
                    <h3>{{ $requests_num }}</h3>
                    <p>Total Requests</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5>Recent Booking Requests</h5>
            <a href="{{ route('request.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Apartment</th>
                        <th>Date</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>


                    @forelse($requests as $req)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">U</div>
                                    <span>{{ $req->student->name }}</span>
                                </div>
                            </td>
                            <td>{{ $req->apartment->name }}</td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>
                            <td>

                                <span
                                    class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>

                        </tr>


                    @empty

                        <tr>
                            <td>No Requests Yet</td>
                        </tr>
                    @endforelse









                </tbody>
            </table>
        </div>
    </div>

    <!-- My Apartments -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5>My Properties</h5>
            <a href="{{ route('owner_apartments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>



                    @forelse($apartments as $apart)
                        @php
                            // Find the image marked as 'is_main'
                            $mainImage = $apart->images->where('is_main', true)->first();
                            // Fallback to the first image if no 'is_main' is found
                            $displayImage = $mainImage ?? $apart->images->first();
                        @endphp



                        <tr>
                            <td><img src="{{ $displayImage ? asset('storage/' . $displayImage->image_path) : asset('images/sample1.jpg') }}" alt="Apt"
                                    class="rounded" width="60" height="40" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold">{{ $apart->name }}</td>


                            @if ($apart->rent_type == 'whole')
                                <td>$ {{ $apart->price }}/mo</td>
                            @elseif($apart->rent_type == 'rooms')
                                <td>$ {{ $apart->price }}/room</td>
                            @endif





                            <td>{{ $apart->location }}</td>
                            <td><span class="badge bg-success">Active</span></td>

                        </tr>




                    @empty
                        <tr>
                            <td>No Apartments Yet </td>
                        </tr>
                    @endforelse








                </tbody>
            </table>
        </div>
    </div>




@endsection


@section('js')

    <script>
        const el = document.getElementById("Dashboard");
        el.classList.add("active");
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection
