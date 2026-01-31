@extends('layouts.master')


@section('title', 'Apartment Details - Sakan')



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
    <link rel="stylesheet" href="{{ asset('css/apartment-details.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


    <style>
        .chat-owner-btn::hover {
            color: white;
        }
    </style>


@endsection


@section('class', 'class="bg-light"')



@section('content')




    <div class="container mt-5 pt-5 pb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="my-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('apartmentspage') }}">Apartments</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $apartment->name }}</li>
            </ol>
        </nav>

        <!-- Gallery -->
        <!-- Gallery Carousel -->
        <div id="apartmentCarousel" class="carousel slide gallery-container mb-4" data-bs-ride="carousel">

            <div class="carousel-indicators">
                @foreach ($apartment->images as $index => $image)
                    <button type="button" data-bs-target="#apartmentCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @forelse ($apartment->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100 carousel-img"
                            alt="Apartment Image">
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/sample1.jpg') }}" class="d-block w-100 carousel-img"
                            alt="No Image Available">
                    </div>
                @endforelse
            </div>

            @if ($apartment->images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#apartmentCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#apartmentCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Header Info -->
                <div class="details-header">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h1 class="h2 fw-bold mb-2">{{ $apartment->name }}</h1>
                            <div class="text-muted mb-2">
                                <i class="bi bi-geo-alt-fill text-primary"></i> {{ $apartment->location }} &bull;
                                <i class="bi bi-mortarboard-fill text-primary ms-2"></i>
                                {{ $apartment->university->name ?? 'none' }}
                                &bull;
                                <i class="bi bi-aspect-ratio text-primary ms-2"></i> {{ $apartment->area }} &bull;

                                @if ($apartment->gender == 'male')
                                    <i class="bi bi-gender-male text-primary ms-2"></i> Males &bull;
                                @elseif($apartment->gender == 'female')
                                    <i class="bi bi-gender-female text-primary ms-2"></i> Females &bull;
                                @endif


                                @if ($apartment->rent_type == 'whole')
                                    <i class="bi bi-house text-primary ms-2"></i> Whole Apartment
                                @elseif($apartment->rent_type == 'rooms')
                                    <i class="bi bi-house text-primary ms-2"></i>
                                    {{ $apartment->number_of_rooms }}
                                    Rooms
                                @endif

                                &bull;

                                @if ($apartment->allowed_gender == 'male')
                                    <i class="bi bi-gender-male"></i>

                                    {{ $apartment->allowed_gender }}
                                @elseif($apartment->allowed_gender == 'female')
                                    <i class="bi bi-gender-female"></i>

                                    {{ $apartment->allowed_gender }}
                                @endif






                            </div>
                        </div>
                        <div class="text-end">


                            @if ($apartment->rent_type == 'whole')
                                <div class="price-tag">${{ $apartment->price }}</div>

                                <div class="price-period">per month</div>
                            @elseif($apartment->rent_type == 'rooms')
                                <div class="price-tag">${{ $apartment->price }}/room</div>

                                <div class="price-period">per month</div>
                            @endif



                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="mb-4">
                    <h4 class="h5 fw-bold mb-3">Key Features</h4>
                    <div class="d-flex flex-wrap">

                        @forelse($apartment->features as $feature)
                            <span class="feature-badge"><i class="bi bi-{{ $feature->name }}"></i>
                                {{ $feature->name }}</span>
                        @empty
                            <span class="feature-badge"><i class="bi bi-wifi"></i>no features</span>
                        @endforelse




                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h4 class="h5 fw-bold mb-3">About this place</h4>
                    <p class="text-muted">
                        {{ $apartment->description }}
                    </p>
                </div>

                <!-- Map Placeholder -->
                <div class="mb-4">
                    <h4 class="h5 fw-bold mb-3">Location</h4>
                    <div id="map" style="height: 400px; z-index: 1;" class="rounded border"></div>
                </div>

                <div class="mt-5">
                    <h4>Comments ({{ $apartment->comments->count() }})</h4>

                    @auth
                        <form action="{{ route('comments.store', $apartment->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" placeholder="Add a comment..."
                                    required>
                                <button class="btn btn-primary" type="submit">Post</button>
                            </div>
                        </form>
                    @else
                        <p class="text-muted">Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
                    @endauth

                    <div class="comment-list">
                        @foreach ($apartment->comments as $comment)
                            <div class="p-3 mb-2 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>

            <!-- Sidebar (Contact) -->
            <div class="col-lg-4">
                <div class="owner-card sticky-top" style="top: 100px;">
                    <h4 class="h5 fw-bold mb-4">Contact Owner</h4>
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('storage/' . $apartment->owner->profile_image) }}" alt="Owner"
                            class="owner-avatar me-3">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $apartment->owner->name ?? 'none' }}</h6>
                            <small class="text-muted">Owner</small>
                        </div>
                    </div>

                    <div class="d-grid gap-2">


                        @if (session('error'))
                            <p class="text-danger">{{ session('error') }}</p>
                        @endif

                        @auth

                            @if (Auth::id() === $apartment->owner_id)
                                {{-- CASE 1: The user OWNS this specific apartment --}}
                                <a href="{{ route('owner_apartments.index', $apartment->id) }}"
                                    class="btn btn-primary w-100">
                                    <i class="bi bi-pencil"></i> Manage My Apartment
                                </a>
                            @elseif (Auth::user()->role == 'owner' || Auth::user()->role == 'admin')
                                {{-- CASE 2: The user is AN owner or admin, but not the owner of THIS house --}}
                                {{-- They still shouldn't be "joining" apartments like a student --}}
                                <p class="text-muted text-center border p-2 rounded">
                                    Owners/Admins cannot request to join.
                                </p>
                            @elseif ($alreadyRequested)
                                {{-- CASE 3: It's a student who already clicked the button --}}
                                <button class="btn btn-success disabled w-100">
                                    <i class="bi bi-check-circle"></i> Requested!
                                </button>
                                <a href="{{ route('messages.show', $apartment->owner_id) }}" class="btn btn-secondary">
                                    Chat with Owner
                                </a>
                            @else


                                <a href="{{ route('apartment.confirm', $apartment->id) }}" class="btn btn-primary">
                                    Request to Join
                                </a>

                                

                                <a href="{{ route('messages.show', $apartment->owner_id) }}" class="btn btn-secondary">
                                    Chat with Owner
                                </a>
                                
                            @endif
                        @endauth



                        @guest

                            <p class="text-danger mt-2">You need to login before requesting.</p>
                            <a href="{{ route('login') }}" class="btn btn-secondary">
                                Login to Book
                            </a>

                        @endguest



                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope text-muted me-2"></i>
                            <span class="text-muted">{{ $apartment->owner->email ?? 'none' }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone text-muted me-2"></i>
                            <span class="text-muted">{{ $apartment->owner->phone ?? 'none' }}</span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <p class="small text-muted mb-0 text-center">
                        <i class="bi bi-shield-check text-success"></i> Payments are secured by Sakan
                    </p>
                </div>
            </div>
        </div>
    </div>






@endsection


@section('js')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Map centered on Cambridge, MA (approx coordinates)
            var map = L.map('map').setView([42.3736, -71.1097], 14);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Add a marker for the apartment
            var marker = L.marker([{{ $apartment->longitude }}, {{ $apartment->latitude }}]).addTo(map)
                .bindPopup('<b>Sunny Studio</b><br>123 Cambridge St.')
                .openPopup();
        });
    </script> --}}



    {{-- view the map --}}
    <script>
        // Get the coordinates from your Laravel variable
        var lat = {{ $apartment->latitude }};
        var lng = {{ $apartment->longitude }};

        var map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Place a fixed marker where the owner pinned it
        L.marker([lat, lng]).addTo(map)
            .bindPopup("{{ $apartment->name }}")
            .openPopup();
    </script>


@endsection
