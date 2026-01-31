<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripePaymentController;

/*
|-------------------------------------------------------------------------- 
| Public Routes (Frontend)
|-------------------------------------------------------------------------- 
*/
// هذه الصفحات عامة لأي زائر
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', fn () => view('frontend.courses'))->name('courses');
Route::get('/course/{course}', [CourseController::class, 'show'])->name('course-details');
Route::get('/courses', [CourseController::class, 'allCourses'])->name('courses');

/*
|-------------------------------------------------------------------------- 
| Authenticated Routes (User)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'is_user'])->group(function () {
    // Dashboard for normal users (Profile page)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // User Dashboard
    Route::get('/user/dashboard', fn () => view('profile.dashboard'))->name('profile.dashboard');

    // Payment page محمية للمستخدمين فقط
    Route::get('/payment', fn () => view('frontend.payment'))->name('payment');
});

/*
|-------------------------------------------------------------------------- 
| Authenticated Routes (Admin)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard for admins
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Courses
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

        // Users CRUD
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // ✅ Lessons / Videos CRUD
        Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
        Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    });

// صفحة الدفع
Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/payment/{course}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{course}', [PaymentController::class, 'fakePay'])->name('payment.store');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{course}', [StripePaymentController::class, 'show'])
        ->name('stripe.payment');

    Route::post('/payment/{course}', [StripePaymentController::class, 'checkout'])
        ->name('stripe.checkout');

    Route::get('/payment-success/{course}', [StripePaymentController::class, 'success'])
        ->name('stripe.success');
});


Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->group(function () {

        Route::get('/payments', 
            [App\Http\Controllers\Admin\PaymentController::class, 'index']
        )->name('admin.payments.index');

    });




/*
|-------------------------------------------------------------------------- 
| Authentication Routes   
|-------------------------------------------------------------------------- 
*/
require __DIR__.'/auth.php';
