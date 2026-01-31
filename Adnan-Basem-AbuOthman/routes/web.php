<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AllApartments;
use App\Http\Controllers\AllUniversities;
use App\Http\Controllers\ApartmentAdminController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerProfileController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UniversitiesController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;



Route::get('', [IndexController::class, 'index'])->name('index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');





// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });




//admin
Route::resource('admin', AdminController::class)->middleware(['auth', 'AdminAuth']);

Route::resource('universities', UniversitiesController::class)->middleware(['auth', 'AdminAuth']);

Route::resource('users', UsersController::class)->middleware(['auth', 'AdminAuth']);

Route::resource('apartments', ApartmentAdminController::class)->middleware(['auth', 'AdminAuth']);

Route::resource('admins', AdminsController::class)->middleware(['auth', 'AdminAuth']);

Route::resource('admin_profile', AdminProfileController::class)->middleware(['auth', 'AdminAuth']);






//owner
Route::resource('owner', OwnerController::class)->middleware(['auth', 'OwnerAuth']);

Route::resource('owner_apartments', ApartmentController::class)->middleware(['auth', 'OwnerAuth']);


Route::resource('request', RequestController::class)->middleware(['auth', 'OwnerAuth']);


// Route::resource('messages', MessagesController::class)->middleware(['auth', 'OwnerAuth']);

Route::resource('ownerprofile', OwnerProfileController::class)->only(['edit', 'update'])->middleware(['auth', 'OwnerAuth']);



//student

Route::get('university', [AllUniversities::class, 'index'])->name('universitiesPage');


Route::get('apartment', [AllApartments::class, 'index'])->name('apartmentspage');


Route::get('/apartment/{apartment}/Confirm Request', [UserRequestController::class, 'index'])
    ->name('apartment.confirm');

// Route for submitting a request
Route::post('/requests/{apartments}', [UserRequestController::class, 'store'])
    ->name('apartment.request');

// // Route for starting a chat
// Route::get('/chat/{apartment}/{user}', [ChatController::class, 'show'])
//     ->name('chat.index');


// Update request status (Approve/Reject)
Route::patch('/owner/requests/{request}/{status}', [RequestController::class, 'updateStatus'])->name('owner.request.status');



Route::get('apartment-deatails/{apartment}', [AllApartments::class, 'show'])->name('apartments_d');


// Route::get('messages_page', function () {

//     return view('messages');

// })->name('messages_page');


// // Student Route
// Route::get('/messages/{id}', [MessagesController::class, 'show'])->name('messages.show');
// // If you have a general index for students
// Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');



// // Unified Messages Routes (Accessible by both Owner and Student)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
//     Route::get('/messages/{id}', [MessagesController::class, 'show'])->name('messages.show');
//     Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
// });




Route::resource('profile', StudentProfileController::class)->middleware('auth');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');



Route::get('/messages/{receiver_id}', [MessageController::class, 'show'])->name('messages.show');



Route::resource('plans', PlansController::class)->middleware(['auth', 'OwnerAuth']);




Route::prefix('plan')->group(function () {

    Route::get('/plans', [PlansController::class, 'index'])->name('plans.index');


});

// Subscription Flow
Route::get('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('plans.subscribe');



// Card Flow
// Notice we use {plan} here so we can easily fetch it in the Controller
Route::get('/card/new/{plan}', [CardController::class, 'create'])->name('card.create');
Route::post('/card/store', [CardController::class, 'store'])->name('card.store');



Route::get('/subscribe/confirm/{plan}', [SubscriptionController::class, 'confirm'])->name('plans.confirm');


Route::post('/subscribe/finalize/{plan}', [SubscriptionController::class, 'finalize'])->name('plans.finalize');

Route::post('/apartments/{apartment}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::delete('/notifications/{id}', function ($id) {
    auth()->user()->notifications()->where('id', $id)->delete();
    return back()->with('success', 'Notification deleted');
})->name('notifications.destroy')->middleware('auth');


require __DIR__ . '/auth.php';






