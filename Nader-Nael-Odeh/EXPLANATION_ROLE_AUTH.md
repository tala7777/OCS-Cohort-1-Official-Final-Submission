# Role-Based Authorization and Redirection Guide

This document explains how we implemented role-based access control (RBAC) and role-specific redirection after login.

## 1. Redirection After Login (`AuthenticatedSessionController`)

We modified `app/Http/Controllers/Auth/AuthenticatedSessionController.php` to check the user's role immediately after authentication.

**Why?**
By default, Breeze redirects everyone to `/dashboard`. Since you have distinct dashboards for Admins, Lawyers, and Users, we intercept the flow and redirect them to their specific routes.

```php
$role = $request->user()->role;

if ($role === 'admin') {
    return redirect()->intended(route('admin.dashboard'));
} elseif ($role === 'lawyer') {
    return redirect()->intended(route('lawyer.dashboard'));
}

return redirect()->intended(route('dashboard'));
```

We applied similar logic to the `RegisteredUserController` so that new sign-ups also go to the right place.

## 2. Protecting Pages (`RoleMiddleware`)

Redirection is not enough; we must also prevent users from accessing pages they don't have permission for (e.g., a normal user typing `/admin/dashboard` in the URL).

**Step 2.1: Created Middleware**
We created `app/Http/Middleware/RoleMiddleware.php`. This class checks if the currently logged-in user matches the required role. If not, it aborts with a `403 Unauthorized` error.

**Step 2.2: Registered Middleware**
We registered this middleware in `bootstrap/app.php` with the alias `'role'`.

**Step 2.3: Applied to Routes**
In `routes/web.php`, we wrapped the Admin and Lawyer route groups with this middleware:

```php
// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () { ... });

// Lawyer Routes
Route::middleware(['auth', 'role:lawyer'])->group(function () { ... });
```

## Summary of Flow

1. **User Logs In**: Logic in Controllers checks role -> Redirects to correct dashboard.
2. **User Navigates**: Logic in `web.php` (Middleware) checks role -> Allows access or blocks with 403 error.
