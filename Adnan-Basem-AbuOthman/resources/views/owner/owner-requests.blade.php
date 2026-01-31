@extends('layouts.owner_master')


@section('title', 'Requests - Owner Dashboard')


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
            <h2 class="fw-bold mb-1">Booking Requests</h2>
            <p class="text-muted">Manage incoming requests from students.</p>
        </div>
    </div>


    @if (session('success'))
        <p class="text-success">{{ session('success') }}</p>
    @endif

    <!-- Requests List -->
    <div class="dashboard-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Apartment</th>
                        <th>Date</th>

                        <th>From</th>

                        <th>To</th>

                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>



                    @forelse($requests as $req)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">JD</div>
                                    <div>
                                        <div class="fw-bold">{{ $req->student->name }}</div>
                                        <small class="text-muted">{{ $req->student->phone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $req->apartment->name }}</td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>

                            <td>
                                {{ $req->start_date->format('d-m') }}
                            </td>

                            <td>
                                {{ $req->end_date->format('d-m') }}

                            </td>


                            <td>
                                <span
                                    class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>

                            <td>


                                <a href="{{ route('messages.show', $req->student->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-chat-dots"></i> Message
                                </a>


                                @if ($req->status !== 'approved')
                                    <form action="{{ route('owner.request.status', [$req->id, 'approved']) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success">Approve</button>
                                    </form>
                                @endif

                                @if ($req->status !== 'rejected')
                                    <form action="{{ route('owner.request.status', [$req->id, 'rejected']) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger">Reject</button>
                                    </form>
                                @endif

                                @if ($req->status !== 'pending')
                                    <form action="{{ route('owner.request.status', [$req->id, 'pending']) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-secondary">Reset</button>
                                    </form>
                                @endif



                                <form action="{{ route('request.destroy', $req->id) }}" method="POST"
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
                            <td colspan="5" class="text-center">No requests found.</td>
                        </tr>
                    @endforelse



                </tbody>
            </table>
        </div>
    </div>


@endsection


@section('js')

    <script>
        const el = document.getElementById("Requests");
        el.classList.add("active");
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
