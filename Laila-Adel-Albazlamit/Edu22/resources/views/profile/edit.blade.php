@extends('layouts.' . auth()->user()->role)

@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-4">My Profile</h1>

        <div class="row">
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" value="+1 234 567 890" readonly>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600 mt-2 text-end">{{ __('Saved.') }}</p>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Change Password</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control"
                                    autocomplete="current-password">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                        class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-warning">Update Password</button>
                            </div>
                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-green-600 mt-2 text-end">{{ __('Saved.') }}</p>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Delete Account (Optional integration from partial if needed, but omitted as per user design request which didn't show it) -->
            </div>
        </div>
    </div>
@endsection