@section('title', 'Signup - Sakan')

<x-guest-layout>
    <div class="auth-container">
        <!-- Visuals Side (Left) -->
        <div class="auth-visuals">
            <div class="visuals-top">
                <div class="text-white fs-3 fw-bold"><a href="{{ route('index') }}">Sakan</a></div>
            </div>
            <div class="visuals-content">
                <h2>Join a Community<br>That Cares.</h2>
                <p class="mt-4">Start your journey today. Find the perfect place or the perfect tenant.</p>
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
                    <h1 class="form-title">Create Account</h1>
                    <p class="form-subtitle">Choose your role and enter your details to get started.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Role Selector -->
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" name="role" id="role-student" value="student" class="role-input"
                                {{ old('role', 'student') === 'student' ? 'checked' : '' }}>
                            <label for="role-student" class="role-label">
                                <i class="bi bi-mortarboard"></i>
                                <span>I'm a Student</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="role-owner" value="owner" class="role-input"
                                {{ old('role') === 'owner' ? 'checked' : '' }}>
                            <label for="role-owner" class="role-label">
                                <i class="bi bi-briefcase"></i>
                                <span>I'm an Owner</span>
                            </label>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="text-danger mb-4 text-center" />

                    <!-- Form Grid -->

                    <div class="form-grid">

                        <!-- Full Name (Full Width) -->
                        <div class="input-group col-span-2">
                            <label for="name" class="label-large">Full Name</label>
                            <input id="name" class="input-large" type="text" name="name"
                                value="{{ old('name') }}" required autofocus placeholder="John Doe" />
                            <x-input-error :messages="$errors->get('name')" class="text-danger mt-2" />
                        </div>

                        <!-- Email (Full Width) -->
                        <div class="input-group col-span-2">
                            <label for="email" class="label-large">Email Address</label>
                            <input id="email" class="input-large" type="email" name="email"
                                value="{{ old('email') }}" required placeholder="name@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="text-danger mt-2" />
                        </div>

                        <!-- Phone (1/2 Width) -->
                        <div class="input-group">
                            <label for="phone" class="label-large">Phone Number</label>
                            <input id="phone" class="input-large" type="tel" name="phone"
                                value="{{ old('phone') }}" required placeholder="+1234567890" />
                            <x-input-error :messages="$errors->get('phone')" class="text-danger mt-2" />
                        </div>

                        <!-- Gender (1/2 Width) -->
                        <div class="input-group">
                            <label for="gender" class="label-large">Gender</label>
                            <select name="gender" id="gender" class="input-large" required>
                                <option value="" selected disabled>Select...</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="text-danger mt-2" />
                        </div>

                        <!-- Password (1/2 Width) -->
                        <div class="input-group">
                            <label for="password" class="label-large">Password</label>
                            <input id="password" class="input-large" type="password" name="password" required
                                placeholder="••••••••" autocomplete="new-password" value="{{ old('phone') }}" />
                            <x-input-error :messages="$errors->get('password')" class="text-danger mt-2" />
                        </div>

                        <!-- Confirm Password (1/2 Width) -->
                        <div class="input-group">
                            <label for="password_confirmation" class="label-large">Confirm Password</label>
                            <input id="password_confirmation" class="input-large" type="password"
                                name="password_confirmation" required placeholder="••••••••" autocomplete="new-password"
                                value="{{ old('password_confirmation') }}" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-2" />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit mt-2">
                        Create Account
                    </button>

                    <!-- Footer -->
                    <div class="form-footer">
                        Already have an account?
                        <a href="{{ route('login') }}">Sign in</a>
                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                       
                        <a href="{{ route('index') }}" style="color: var(--text-sub); font-weight: normal;">
                            Go back home
                        </a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
