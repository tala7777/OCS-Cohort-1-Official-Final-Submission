@extends('layouts.owner_master')


@section('title', 'Checkout - Sakan')


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




    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* Styling for Stripe Element */
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }
    </style>

@endsection







@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('plans.index') }}" class="text-decoration-none text-muted me-3">
                <i class="bi bi-arrow-left"></i> Back to Plans
            </a>
            <h2 class="fw-bold mb-0">Secure Checkout</h2>
        </div>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4">Payment Methods</h4>

                    <form id="payment-form" action="{{ route('card.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <input type="hidden" name="card_token" id="card_token">

                        <div class="mb-3">
                            <label class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardName" placeholder="John Doe" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Card Details</label>
                            <div id="card-element"></div>
                            <div id="card-errors" class="text-danger mt-2 small" role="alert"></div>
                        </div>

                        <button type="submit" id="checkout-btn" class="btn btn-primary w-100 py-3 fw-bold fs-5 shadow-sm">
                            <span id="btn-text">Save & Continue</span>
                            <span id="btn-spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 bg-light p-4">
                    <h4 class="mb-4">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Plan</span>
                        <span class="fw-bold">{{ $plan->name }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5">Total</span>
                        <span class="h3 fw-bold text-primary">${{ number_format($plan->price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('js')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentForm = document.getElementById('payment-form');
            const checkoutBtn = document.getElementById('checkout-btn');
            const tokenInput = document.getElementById('card_token');

            if (!paymentForm) {
                console.error("Form not found! Check your ID.");
                return;
            }

            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log("1. Submit intercepted...");

                // UI Changes
                checkoutBtn.disabled = true;
                document.getElementById('btn-text').classList.add('d-none');
                document.getElementById('btn-spinner').classList.remove('d-none');

                console.log("2. Simulating External API Call (2 seconds)...");

                setTimeout(() => {
                    // Generate Fake Token
                    const fakeToken = "tok_sakan_" + Math.random().toString(36).substr(2, 10);

                    // Set value to hidden input
                    tokenInput.value = fakeToken;

                    console.log("3. Token created: " + fakeToken);
                    console.log("4. Sending data to Laravel Route: {{ route('card.store') }}");

                    // Use the standard form submit
                    paymentForm.submit();
                }, 2000);
            });
        });
    </script> --}}


    <script>
        // Initialize Stripe (Replace with your actual public key)
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();

        // Create the card element
        const card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const checkoutBtn = document.getElementById('checkout-btn');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // UI Loading
            checkoutBtn.disabled = true;
            document.getElementById('btn-text').classList.add('d-none');
            document.getElementById('btn-spinner').classList.remove('d-none');

            // Request Token from Stripe
            const {
                token,
                error
            } = await stripe.createToken(card, {
                name: document.getElementById('cardName').value
            });

            if (error) {
                // Handle error
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                checkoutBtn.disabled = false;
                document.getElementById('btn-text').classList.remove('d-none');
                document.getElementById('btn-spinner').classList.add('d-none');
            } else {
                // Insert Token ID into hidden field and submit
                document.getElementById('card_token').value = token.id;
                form.submit();
            }
        });
    </script>





    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to parse URL params and update summary
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const plan = params.get('plan');
            const price = params.get('price');

            if (plan && price) {
                const planNameMap = {
                    'starter': 'Starter Plan',
                    'professional': 'Professional Plan',
                    'enterprise': 'Enterprise Plan'
                };

                document.getElementById('planName').textContent = planNameMap[plan] || 'Unknown Plan';
                document.getElementById('planPrice').textContent = '$' + parseFloat(price).toFixed(2);
            }
        });
    </script>


    <script>
        const el = document.getElementById("Apartments");
        el.classList.add("active");
    </script>


@endsection
