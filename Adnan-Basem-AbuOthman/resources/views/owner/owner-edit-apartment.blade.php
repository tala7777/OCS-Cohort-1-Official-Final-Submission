@extends('layouts.owner_master')

@section('title', 'Edit Apartment - Owner Dashboard')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />





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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('owner_apartments.index') }}"
                            class="text-decoration-none">My
                            Apartments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Apartment</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">Edit: {{ $apartment->name }}</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-card">
        <div class="card-body p-4">
            <form action="{{ route('owner_apartments.update', $apartment->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-12">
                        <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                    </div>

                    <div class="col-md-12">
                        <label for="apartmentName" class="form-label">Apartment Name</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $apartment->name) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Apartment Images</label>
                        <div class="p-5 text-center bg-light rounded border border-2 border-secondary border-opacity-25 position-relative"
                            style="border-style: dashed !important; cursor: pointer;"
                            onclick="document.getElementById('apartmentImages').click()">

                            <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 justify-content-center">
                                @foreach ($apartment->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="rounded object-fit-cover border shadow-sm"
                                        style="width: 80px; height: 80px;">
                                @endforeach
                            </div>
                            <div id="uploadPrompt" class="{{ $apartment->images->count() > 0 ? 'mt-2' : '' }}">
                                <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                <h6 class="mb-1">Click to replace all images</h6>
                                <p class="text-muted small">Current photos will be removed if you upload new ones.</p>
                            </div>
                            <input type="file" name="images[]" id="apartmentImages" multiple accept="image/*"
                                class="d-none">
                        </div>
                        <small class="text-muted">Note: Uploading new images will replace the current ones.</small>
                    </div>

                    <div class="col-md-6">
                        <label for="apartmentLocation" class="form-label">Location</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control" name="location"
                                value="{{ old('location', $apartment->location) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="apartmentArea" class="form-label">Area (sqm)</label>
                        <div class="input-group">
                            <input type="number" name="area" class="form-control"
                                value="{{ old('area', $apartment->area) }}" required>
                            <span class="input-group-text">m²</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pin Location on Map</label>
                        <div id="map" style="height: 300px;" class="rounded border"></div>
                        <input type="hidden" id="apartmentLat" name="latitude" value="{{ $apartment->latitude }}">
                        <input type="hidden" id="apartmentLng" name="longitude" value="{{ $apartment->longitude }}">
                    </div>

                    <div class="col-md-6">
                        <label for="nearestUniversity" class="form-label">Nearest University</label>
                        <select class="form-select" name="university_id" required>
                            @foreach ($universities as $uni)
                                <option value="{{ $uni->id }}"
                                    {{ $apartment->university_id == $uni->id ? 'selected' : '' }}>
                                    {{ $uni->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="apartmentGender" class="form-label">Allowed Gender</label>
                        <select class="form-select" name="gender" required>
                            <option value="male" {{ $apartment->allowed_gender == 'male' ? 'selected' : '' }}>Males
                            </option>
                            <option value="female" {{ $apartment->allowed_gender == 'female' ? 'selected' : '' }}>Females
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="apartmentDescription" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required>{{ old('description', $apartment->description) }}</textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <h5 class="mb-3 border-bottom pb-2">Rent & Pricing Details</h5>
                    </div>

                    <div class="col-12">
                        <label class="form-label d-block">Rent Type</label>
                        <div class="btn-group">
                            <input type="radio" class="btn-check" name="rentType" id="rentWhole" value="whole"
                                {{ $apartment->rent_type == 'whole' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="rentWhole">Whole Apartment</label>

                            <input type="radio" class="btn-check" name="rentType" id="rentRooms" value="rooms"
                                {{ $apartment->rent_type == 'rooms' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="rentRooms">Separate Rooms</label>
                        </div>
                    </div>

                    <div class="col-md-6" id="wholePriceContainer">
                        <label class="form-label">Price for Whole Apartment</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" class="form-control" id="wholePrice"
                                value="{{ $apartment->rent_type == 'whole' ? $apartment->price : '' }}">
                            <span class="input-group-text">/mo</span>
                        </div>
                    </div>

                    <div class="col-md-12 row g-3 d-none" id="roomsContainer">
                        <div class="col-md-6">
                            <label class="form-label">Number of Rooms</label>
                            <input type="number" name="number_of_rooms" class="form-control" id="numberOfRooms"
                                value="{{ $apartment->number_of_rooms }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price per Room</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="room_price" class="form-control" id="roomPrice"
                                    value="{{ $apartment->rent_type == 'rooms' ? $apartment->price : '' }}">
                                <span class="input-group-text">/mo</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <h5 class="mb-3 border-bottom pb-2">Features & Amenities</h5>
                    </div>
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="featureInput" placeholder="Add a feature">
                            <button class="btn btn-outline-primary" type="button" id="addFeatureBtn">Add</button>
                        </div>
                        <div id="featuresContainer" class="d-flex flex-wrap gap-2 mb-2">
                            @foreach ($apartment->features as $feature)
                                <span class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2">
                                    {{ $feature->name }}
                                    <i class="bi bi-x text-danger feature-remove" style="cursor: pointer;"></i>
                                </span>
                            @endforeach
                        </div>
                        <input type="hidden" name="features" id="featuresList"
                            value='{{ $apartment->features->pluck('name')->toJson() }}'>
                    </div>

                    <div class="col-12 mt-5 d-flex gap-2 justify-content-end">
                        <a href="{{ route('owner_apartments.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Map Logic ---
            const lat = {{ $apartment->latitude }};
            const lng = {{ $apartment->longitude }};
            var map = L.map('map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            var marker = L.marker([lat, lng]).addTo(map);

            map.on('click', function(e) {
                if (marker) marker.setLatLng(e.latlng);
                else marker = L.marker(e.latlng).addTo(map);
                document.getElementById('apartmentLat').value = e.latlng.lat;
                document.getElementById('apartmentLng').value = e.latlng.lng;
            });

            // --- Features Logic ---
            const featureInput = document.getElementById('featureInput');
            const featuresContainer = document.getElementById('featuresContainer');
            const featuresListInput = document.getElementById('featuresList');

            function updateFeaturesList() {
                const features = Array.from(featuresContainer.children).map(badge => badge.childNodes[0].textContent
                    .trim());
                featuresListInput.value = JSON.stringify(features);
            }

            document.getElementById('addFeatureBtn').addEventListener('click', function() {
                const val = featureInput.value.trim();
                if (val) {
                    const span = document.createElement('span');
                    span.className = 'badge bg-light text-dark border p-2 d-flex align-items-center gap-2';
                    span.innerHTML =
                        `${val} <i class="bi bi-x text-danger feature-remove" style="cursor: pointer;"></i>`;
                    featuresContainer.appendChild(span);
                    featureInput.value = '';
                    updateFeaturesList();
                }
            });

            featuresContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('feature-remove')) {
                    e.target.parentElement.remove();
                    updateFeaturesList();
                }
            });

            // --- Pricing Toggle ---
            const rentWhole = document.getElementById('rentWhole');
            const roomsContainer = document.getElementById('roomsContainer');
            const wholePriceContainer = document.getElementById('wholePriceContainer');

            function togglePricing() {
                if (rentWhole.checked) {
                    wholePriceContainer.classList.remove('d-none');
                    roomsContainer.classList.add('d-none');
                } else {
                    wholePriceContainer.classList.add('d-none');
                    roomsContainer.classList.remove('d-none');
                }
            }
            rentWhole.addEventListener('change', togglePricing);
            document.getElementById('rentRooms').addEventListener('change', togglePricing);
            togglePricing(); // Run once on load
        });
    </script>


    <script>
        const el = document.getElementById("Apartments");
        el.classList.add("active");
    </script>
@endsection
