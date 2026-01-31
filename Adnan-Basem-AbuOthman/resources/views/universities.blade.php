@extends('layouts.master')




@section('title', 'All Universities - Sakan')



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
    <link rel="stylesheet" href="{{ asset('css/universities.css') }}">


@endsection



@section('content')





    <!-- Page Header -->
    <header class="page-header mt-5 pt-5">
        <div class="container"><br>
            <h1>All Universities</h1>
            <p>Find student housing near your preferred campus.</p>
        </div>
    </header>



    <!-- Universities Grid -->
    <section class="section pt-0">
        <div class="container">
            <div class="row g-4">


                @forelse($universities as $uni)
                    <!-- Card 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card university-card">
                            <img src="{{ asset('storage/' . $uni->image) }}"
                                class="card-img-top" alt="Harvard">
                            <div class="card-body">
                                <h5 class="card-title">{{ $uni->name}}</h5>
                                <div class="university-location">
                                    <i class="bi bi-geo-alt"></i> {{ $uni->location }}
                                </div>
                                <a href="{{ route('apartmentspage', ['university_id' => $uni->id]) }}" class="btn btn-outline-primary w-100">View
                                    Apartments</a>
                            </div>
                        </div>
                    </div>

                @empty

                    <p>no universities yet</p>

                @endforelse






            </div>
        </div>
    </section>


@endsection




@section('js')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
