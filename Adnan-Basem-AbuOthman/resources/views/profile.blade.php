@extends('layouts.master')

@section('title', 'My Profile - Sakan')


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
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">



@endsection



@section('class', 'class="bg-light"')



@section('content')




    <div class="container mt-5 pt-5 pb-5">

        <div class="profile-header-card mb-5">
            <h2 class="fw-bold text-white fs-1">My Profile</h2><br>
            <div class="profile-avatar-wrapper">
                @php
                    // FIX: Changed $owner to $user
                    $avatarUrl = $user->profile_image
                        ? asset('storage/' . $user->profile_image)
                        : 'https://ui-avatars.com/api/?name=' .
                            urlencode($user->name) .
                            '&background=1E3A8A&color=fff&size=128';
                @endphp
                <img src="{{ $avatarUrl }}" alt="Profile" class="profile-avatar" id="avatarPreview">
            </div>
        </div>


        <div class="row">


            <div class="col-md-6">

                <!-- content -->
                <div class="profile-form-card mt-5">

                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <p class="text-success">{{ session('success') }}</p>
                        @endif

                        @if (session('error'))
                            <p class="text-danger">{{ session('error') }}</p>
                        @endif


                        <div class="section-label">Personal Information</div>
                        <div class="row g-4 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                            </div>

                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="fullName"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}">
                                <div class="form-text">Contact support to change email.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" id="phone"
                                    value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="section-label">Security</div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="currentPassword"
                                    placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="newPassword"
                                    placeholder="Leave blank to keep current">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <button type="button" class="btn btn-secondary text-primary border-primary">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="col-md-6">

                <div class="mt-5">

                    <div class="profile-form-card mt-5">
                        <div class="section-label">My Requests</div>

                        @if (session('req'))
                            <p class="text-success"> {{ session('req') }}</p>
                        @endif

                        <div class="dashboard-card">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>

                                            <th>Status</th>
                                            <th>from</th>
                                            <th>to</th>


                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($my_requests as $req)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('apartments_d', $req->apartment_id) }}">

                                                        {{ $req->apartment->name }}

                                                    </a>

                                                </td>




                                                <td>
                                                    <span
                                                        class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'rejected' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($req->status) }}
                                                    </span>


                                                </td>

                                                <td>

                                                    {{ $req->start_date->format('d-m') }}
                                                   

                                                </td>

                                                <td>

                                                   
                                                    {{ $req->end_date->format('d-m') }}

                                                </td>



                                                <td>

                                                    <form action="{{ route('profile.destroy', $req->id) }}" method="POST"
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
                                                    No Requests yet.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>



                            </div>
                        </div>





                    </div>
                </div>



            </div>




        </div>


    @endsection



    @section('js')

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JS -->
        <script src="{{ asset('js/main.js') }}"></script>





        <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('avatarPreview');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/sweet.js') }}"></script>


    @endsection
