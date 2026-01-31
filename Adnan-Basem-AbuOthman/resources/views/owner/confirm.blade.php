@extends('layouts.owner_master')
@section('title', 'Confirm Subscription - Sakan')



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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-shield-check fs-1 text-primary"></i>
                        </div>
                        <h2 class="fw-bold">Confirm Purchase</h2>
                        <p class="text-muted">You're almost there! Please review your upgrade.</p>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Selected Plan:</span>
                            <span class="fw-bold">{{ $plan->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Apartment Limit:</span>
                            <span class="fw-bold">{{ $plan->max_apartments }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2">
                            <span class="fw-bold">Total Amount:</span>
                            <span class="fw-bold text-primary fs-5">${{ number_format($plan->price, 2) }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted mb-2 d-block">Payment Method</label>
                        <div class="border rounded p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-credit-card-2-back me-2"></i>
                                <span class="fw-medium">Saved Card (ending in ****)</span>
                            </div>
                            <a href="{{ route('card.create', ['plan' => $plan->id]) }}"
                                class="btn btn-sm btn-link text-decoration-none">Change</a>
                        </div>
                    </div>

                    <form action="{{ route('plans.finalize', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                            Confirm & Pay Now
                        </button>
                    </form>

                    <a href="{{ route('plans.index') }}"
                        class="btn btn-link w-100 text-muted mt-2 text-decoration-none">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
