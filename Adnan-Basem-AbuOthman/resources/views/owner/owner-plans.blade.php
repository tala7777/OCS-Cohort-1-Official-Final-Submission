@extends('layouts.owner_master')


@section('title', 'Subscription Plans - Sakan')


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
        .pricing-card {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .pricing-card.popular {
            border: 2px solid var(--primary-color);
            background: #fff;
        }

        .pricing-card.popular::before {
            content: 'Most Popular';
            position: absolute;
            top: 20px;
            right: -32px;
            background: var(--primary-color);
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .plan-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #111827;
        }

        .plan-period {
            font-size: 1rem;
            color: #6b7280;
            font-weight: 400;
        }

        .feature-list li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            color: #4b5563;
        }

        .feature-list i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
    </style>


@endsection

@section('content')

    <div class="container-fluid p-0">
        <div class="text-center mb-5 mw-700 mx-auto">
            <h2 class="fw-bold display-6 mb-3">Upgrade Your Hosting Journey</h2>
            <p class="text-muted lead">Choose a plan that fits your needs. Scale your property business with
                premium tools and reach.</p>
        </div>



        @if (session('error'))
            <p class="text-danger">{{ session('error') }}</p>
        @endif

        <div class="row g-4 justify-content-center">



            @forelse ($plans as $plan)
                <!--  Plan -->
                <div class="col-md-6 col-lg-4">
                    <div class="pricing-card p-4">
                        <h4 class="fw-bold mb-3">{{ $plan->name }}</h4>
                        <div class="mb-4">
                            <span class="plan-price">$ {{ $plan->price }}</span>
                            <span class="plan-period">{{ $plan->duration_days }}/ Day</span>
                        </div>
                        <p class="text-muted mb-4">{{ $plan->description }}</p>


                        @if ($plan->name == 'Starter')
                            <ul class="list-unstyled feature-list mb-5">
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Post up to
                                    {{ $plan->max_apartments }} Apartments</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Basic Support</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Standard Visibility</li>
                                <li><i class="bi bi-x-circle text-muted opacity-50"></i> Featured Listings</li>
                                <li><i class="bi bi-x-circle text-muted opacity-50"></i> Analytics Dashboard</li>
                            </ul>
                        @elseif($plan->name == 'Professional')
                            <ul class="list-unstyled feature-list mb-5">
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Post up to
                                    {{ $plan->max_apartments }} Apartments</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Priority Support</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Enhanced Visibility</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Featured Listings</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Basic Analytics</li>
                            </ul>
                        @elseif($plan->name == 'Enterprise')
                            <ul class="list-unstyled feature-list mb-5">

                                <li><i class="bi bi-check-circle-fill text-primary"></i> Unlimited Apartments</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> 24/7 Dedicated Support</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Top Search Ranking</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Unlimited Featured Listings
                                </li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Advanced Analytics</li>
                            </ul>
                        @endif




                        <div class="mt-auto">


                            <a href="{{ route('plans.subscribe', $plan->id) }}"
                                class="btn btn-outline-primary w-100 py-3 fw-semibold">
                                Go Premium
                            </a>




                        </div>
                    </div>
                </div>




            @empty
                <p>no plans yet</p>
            @endforelse



        </div>
    </div>




@endsection


@section('js')

    <script>
        const el = document.getElementById("Apartments");
        el.classList.add("active");
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
