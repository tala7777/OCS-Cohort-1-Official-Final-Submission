@section('title', 'Login - Sakan')

<x-guest-layout>
    <div class="auth-container">
        <!-- Visuals Side (Left) -->
        <div class="auth-visuals">
            <div class="visuals-top">
                <div class="text-white fs-3 fw-bold"><a href="{{ route('index') }}">Sakan</a></div>
            </div>
            <div class="visuals-content">
                <h2>Welcome to your<br>Housing Community.</h2>
                <p class="mt-4">Login to access your bookings, messages, and apartment details.</p>
            </div>
            <div class="visuals-footer small opacity-75">
                &copy; {{ date('Y') }} Sakan Housing Platform
            </div>
        </div>

        <!-- Form Side (Right) -->
        <div class="auth-form-side">
            <div class="form-wrapper">
                <!-- Header -->
                <div class="form-header">
                    <a href="{{ url('/') }}" class="brand-logo d-lg-none">Sakan</a>
                    <h1 class="form-title">Log In</h1>
                    <p class="form-subtitle">Welcome back! Please enter your details.</p>
                </div>

                <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="input-group">
                        <label for="email" class="label-large">Email</label>
                        <input id="email" class="input-large" type="email" name="email" value="{{ old('email') }}"
                            required autofocus placeholder="Enter your email" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password" class="label-large">Password</label>
                        <input id="password" class="input-large" type="password" name="password" required
                            autocomplete="current-password" placeholder="Enter your password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="form-actions-row">
                        <label class="custom-check">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember for 30 days</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-pass">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-submit">
                        Log In
                    </button>

                    <!-- Footer -->
                    <div class="form-footer">
                        Don't have an account?
                        <a href="{{ route('register') }}">Sign up</a>
                        <br><br>
                        <a href="{{ route('index') }}" style="color: var(--text-sub); font-weight: normal;">
                            Go back home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>