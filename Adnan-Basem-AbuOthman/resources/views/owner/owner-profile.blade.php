@extends('layouts.owner_master')


@section('title', 'My Profile - Owner Dashboard')


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
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}"> <!-- Reusing profile styles -->

@endsection


@section('content')



    <div class="profile-header-card mb-5">
        <h2 class="fw-bold fs-1"><br></h2>
        <div class="profile-avatar-wrapper">
            @php
                $avatarUrl = $owner->profile_image
                    ? asset('storage/' . $owner->profile_image)
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode($owner->name) .
                        '&background=1E3A8A&color=fff&size=128';
            @endphp
            <img src="{{ $avatarUrl }}" alt="Profile" class="profile-avatar" id="avatarPreview">
        </div>
    </div>

    <div class="profile-form-card">
        <form action="{{ route('ownerprofile.update', $owner->id) }}" method="POST" enctype="multipart/form-data">
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
                <div class="col-md-12">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $owner->name }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $owner->email }}">
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" id="phone" value="{{ $owner->phone }}">
                </div>
            </div>

            <div class="section-label">Security</div>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" id="current_password"
                        placeholder="••••••••">
                </div>
                <div class="col-md-6">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password"
                        placeholder="Leave blank to keep current">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-5">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>




    </div>
@endsection


@section('js')

    <script>
        const el = document.getElementById("Profile");
        el.classList.add("active");
    </script>


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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
