<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Admin\AcademicYearController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin')
        return redirect()->route('admin.dashboard');
    if ($role === 'teacher')
        return redirect()->route('teacher.dashboard');
    if ($role === 'student')
        return redirect()->route('student.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('classes', SchoolClassController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('users', UserController::class);
    Route::get('/get-sections/{classId}', [UserController::class, 'getSections'])->name('users.getSections');
    Route::post('/academic-year/promote', [AcademicYearController::class, 'promoteStudents'])->name('academic-year.promote');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::resource('assignments', AssignmentController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::get('/grades/create', [\App\Http\Controllers\Teacher\GradeController::class, 'create'])->name('grades.create');
    Route::post('/grades', [\App\Http\Controllers\Teacher\GradeController::class, 'store'])->name('grades.store');
    Route::resource('subjects', \App\Http\Controllers\Teacher\SubjectController::class)->only(['index', 'show']);
    Route::get('/grades', [\App\Http\Controllers\Teacher\GradeController::class, 'index'])->name('grades.index');
    Route::post('/attendance/{attendance}/approve-reason', [AttendanceController::class, 'approveReason'])->name('attendance.approve-reason');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/assignments', [AssignmentController::class, 'studentIndex'])->name('assignments.index');
    Route::get('/attendance', [AttendanceController::class, 'studentIndex'])->name('attendance.index');
    Route::get('/subjects', [StudentDashboardController::class, 'subjects'])->name('subjects.index');
    Route::get('/grades', [StudentDashboardController::class, 'grades'])->name('grades.index');
    Route::post('/attendance/{attendance}/submit-reason', [AttendanceController::class, 'submitReason'])->name('attendance.submit-reason');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
