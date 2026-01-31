# Breeze Integration Explanation

This document explains the steps taken to link your custom UI (`public.register` and `public.login`) with Laravel Breeze's authentication logic.

## 1. Updated `routes/web.php`

- **Action**: Commented out the `Route::view` lines for `/login` and `/register`.
- **Reason**: Laravel Breeze comes with its own `routes/auth.php` file that defines these routes and points them to specific Controllers (`RegisteredUserController` and `AuthenticatedSessionController`). By removing the overrides in `web.php`, we ensure your app uses the logic inside these controllers (like checking if a user is already logged in, etc.) rather than just showing a static view.

## 2. Updated `app/Http/Controllers/Auth/RegisteredUserController.php`

- **Action**: Changed `return view('auth.register')` to `return view('public.register')`.
- **Reason**: This tells Breeze to load your custom design instead of the default Breeze registration page.
- **Action**: Updated the `store` method to accept and save a `role`.
- **Reason**: Your UI allows registering as a "User" or "Legal Professional". We added logic to save this distinction in the database during user creation.

## 3. Updated `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

- **Action**: Changed `return view('auth.login')` to `return view('public.login')`.
- **Reason**: To serve your custom login design instead of the default Breeze login page.

## 4. Modified `resources/views/public/register.blade.php`

- **Action**: Added `form` attributes (`method="POST"`, `action="{{ route('register') }}"`).
- **Action**: Added `@csrf` token field.
- **Reason**: Laravel requires this token to protect against Cross-Site Request Forgery attacks. Forms won't submit without it.
- **Action**: Added `name` attributes to inputs (e.g., `name="name"`, `name="email"`).
- **Reason**: The backend controller identifies data by these names. Without them, the server receives nothing.
- **Action**: Added Validation Error display (`@error('field')`).
- **Reason**: If registration fails (e.g., password too short), the user needs to see the error message.
- **Action**: Added Hidden Input for Role (`<input type="hidden" name="role" value="...">`).
- **Reason**: The controller needs to know which tab (User or Lawyer) was used so it can assign the correct role.

## 5. Modified `resources/views/public/login.blade.php`

- **Action**: Replaced the JavaScript `onsubmit` logic with a standard HTML form submission to `{{ route('login') }}`.
- **Action**: Added `@csrf` and `name` attributes for email and password.
- **Reason**: Like the register page, this links the visual inputs to the backend authentication system that verifies credentials.

## Next Steps

- **Lawyer Profile Fields**: The current setup registers the account but doesn't yet save the extra lawyer fields (Specialization, Bar ID, Bio, CV). To support this, you would need to:
    1. Create a migration for a `lawyer_profiles` table.
    2. Create a `LawyerProfile` model.
    3. Update the `RegisteredUserController` to create this profile record when a lawyer registers.
