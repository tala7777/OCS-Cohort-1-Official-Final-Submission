@extends('layouts.owner_master')


@section('title', 'My Apartments - Owner Dashboard')


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


    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">My Apartments</h2>
            <p class="text-muted">Manage your property listings.</p>
        </div>
        <a href="{{ route('owner_apartments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New
            Apartment</a>
    </div>


    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif




    <!-- Apartments List -->
    <div class="dashboard-card ">
        <div class="table-responsive ">




            <table class="table mb-0 ">
                <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Views</th>
                        <th class="text-center">Status</th>
                        <th colspan="3" class="text-center">Actions</th>
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

                        <tr class="text-center">
                            <td>
                                <img src="{{ $displayImage ? asset('storage/' . $displayImage->image_path) : asset('images/sample1.jpg') }}"
                                    alt="Apt" class="rounded" width="60" height="40" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold">{{ $apart->name }}</td>

                            <td>
                                @if ($apart->rent_type == 'whole')
                                    {{ $apart->price }} /mo
                                @else
                                    {{ $apart->price }} /room
                                @endif
                            </td>

                            <td>{{ $apart->location }}</td>
                            <td>{{ $apart->views }}</td>
                            <td><span class="badge bg-success">{{ $apart->status }}</span></td>
                            <td>
                                <a href="{{ route('owner_apartments.edit', $apart->id) }}"
                                    class="btn btn-sm btn-light text-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>


                            </td>

                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        View Students
                                    </button>
                                    <ul class="dropdown-menu shadow">


                                        @forelse($apart->requests as $request)
                                            @php
                                                $statusClasses = [
                                                    'approved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    'pending' => 'bg-warning text-dark',
                                                ];
                                                $class = $statusClasses[$request->status] ?? 'bg-secondary';
                                            @endphp


                                            <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                <span>{{ $request->student->name }}</span>

                                                <span class="badge {{ $class }}">{{ $request->status }}</span>

                                            </li>


                                        @empty
                                            <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                <span>No Requests</span>
                                            </li>
                                        @endforelse





                                    </ul>
                                </div>

                            </td>




                            <td>

                                <form action="{{ route('owner_apartments.destroy', $apart->id) }}" method="POST"
                                    class="d-inline delete-form">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>



                            </td>




                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No apartments yet. <a href="{{ route('owner_apartments.create') }}">Click here to add
                                    one.</a>
                            </td>
                        </tr>
                    @endforelse








                </tbody>
            </table>
        </div>
    </div>





@endsection


@section('js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/sweet.js') }}"></script>


    <script>
        const el = document.getElementById("Apartments");
        el.classList.add("active");
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection
