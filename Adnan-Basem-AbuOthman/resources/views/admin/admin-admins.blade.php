@extends('layouts.admin_master')



@section('title', 'Admins - Admin Dashboard')


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
            <h2 class="fw-bold mb-1">Admins</h2>
            <p class="text-muted">Manage system administrators.</p>
        </div>
        <a href="{{ route('admins.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> 
            Add Admin</a>
    </div>


    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif


    <!-- Admins List -->
    <div class="dashboard-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>email</th>
                        <th>Phone Number</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td class="text-end">

                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
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
                                No Admins yet.
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
        const el = document.getElementById("Admins");
        el.classList.add("active");
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
