@extends('layouts.admin_master')



@section('title', 'Edit University - Sakan Admin')



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
        .upload-zone {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background-color: #f8fafc;
        }
    </style>


@endsection


@section('content')


    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('universities.index') }}"
                            class="text-decoration-none">Universities</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit University</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-1">Edit University</h2>
            <p class="text-muted">Update university details.</p>
        </div>
        <a href="{{ route('universities.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i>
            Back to List</a>
    </div>

    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card p-4 p-md-5">
                    <form action="{{ route('universities.update', $university->id) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-12">
                                <label for="uniName" class="form-label fw-bold">University Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" id="uniName"
                                    value="{{ $university->name }}" required>
                            </div>

                            <!-- Location -->
                            <div class="col-12">
                                <label for="uniLocation" class="form-label fw-bold">Location</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-geo-alt text-muted"></i></span>
                                    <input type="text" name="location" class="form-control form-control-lg"
                                        id="uniLocation" value="{{ $university->location }}" required>
                                </div>
                            </div>

                            <!-- Formal Image Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Formal Image</label>
                                <div class="upload-zone p-5 text-center rounded bg-light position-relative"
                                    onclick="document.getElementById('fileInput').click()">
                                    <div id="uploadPrompt" class="d-none">
                                        <div class="mb-3">
                                            <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center"
                                                style="width: 64px; height: 64px;">
                                                <i class="bi bi-cloud-arrow-up text-primary fs-3"></i>
                                            </div>
                                        </div>
                                        <h5 class="fw-bold mb-1">Click to upload or drag and drop</h5>
                                        <p class="text-muted small mb-0">SVG, PNG, JPG or GIF (max. 800x400px)
                                        </p>
                                    </div>
                                    <img src="{{ $university->image ? asset('storage/' . $university->image) : asset('images/sample1.jpg') }}"
                                        id="imagePreview" class="img-fluid rounded"
                                        style="max-height: 200px; object-fit: cover;">
                                    <input type="file" name="image" id="fileInput" class="d-none" accept="image/*">
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-12 mt-4 d-flex justify-content-end gap-3">
                                <a href="{{ route('universities.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                                @method('PUT') <button type="submit" class="btn btn-primary btn-lg px-4">Save
                                    Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection




@section('js')



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to show selected filename
        // Script to show image preview
        const fileInput = document.getElementById('fileInput');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const imagePreview = document.getElementById('imagePreview');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    uploadPrompt.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        const el = document.getElementById("Universities");
        el.classList.add("active");
    </script>



@endsection
