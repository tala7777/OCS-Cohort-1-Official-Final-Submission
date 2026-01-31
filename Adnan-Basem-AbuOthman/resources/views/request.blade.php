@extends('layouts.master')

@section('title', 'Request to Join')

@section('head')
    <!-- Ensure nice fonts and icons are loaded if not already in master -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />






@endsection

@section('content')

    <br><br>

    <!-- Custom container width as requested (80%) -->
    <div style="width: 80%; margin: 3rem auto;">

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">

                <div class="mb-4 pb-3 border-bottom">
                    <h2 class="fw-bold text-dark">Request to Join</h2>
                    <p class="text-muted mb-0">Booking details for <span class="fw-semibold text-primary"><a
                                href="{{ route('apartments_d', $apartment->id) }}">{{ $apartment->name }}</a></span></p>
                </div>

                <form action="{{ route('apartment.request', $apartment->id) }}" method="POST">
                    @csrf
                    

                    <!-- Student Information Section -->
                    <h5 class="fw-bold mb-3 text-secondary d-inline">Student Information</h5>

                    <a href="{{ route('profile.edit', Auth::user()->id) }}">Edit My Information</a>
                    <br><br>

                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Full Name</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Email Address</label>
                            <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase fw-bold">Phone Number</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->phone ?? 'N/A' }}"
                                disabled>
                        </div>

                    </div>


                    <!-- Booking Period Section -->
                    <h5 class="fw-bold mb-3 text-secondary">Booking Period</h5>
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-bold">Check-In Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" required min="{{ date('Y-m-d') }}">
                            </div>
                            @error('start_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-bold">Check-Out Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" required min="{{ date('Y-m-d') }}">
                            </div>
                            @error('end_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('apartmentspage') }}" class="btn btn-outline-secondary px-4">Cancel</a>




                        <button type="submit" class="btn btn-primary px-5 fw-bold">Send Request</button>






                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->

    <script>
        // Date Validation Logic
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        startDate.addEventListener('change', function() {
            endDate.min = this.value;
        });
    </script>
@endsection
