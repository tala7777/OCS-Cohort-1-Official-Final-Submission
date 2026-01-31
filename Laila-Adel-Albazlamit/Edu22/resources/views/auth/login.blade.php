<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="card login-card p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-mortarboard-fill text-primary" style="font-size: 3rem;"></i>
                <h4 class="mt-2 fw-bold">EduTrack Login</h4>
                <p class="text-muted small">Enter your credentials to access the portal</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info small mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-envelope text-muted"></i></span>
                        <input id="email" type="email" name="email"
                            class="form-control bg-light border-start-0 @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-lock text-muted"></i></span>
                        <input id="password" type="password" name="password"
                            class="form-control bg-light border-start-0 @error('password') is-invalid @enderror"
                            required autocomplete="current-password">
                    </div>
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-4 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-bold">Sign In</button>
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="small text-decoration-none text-muted" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>

</html>