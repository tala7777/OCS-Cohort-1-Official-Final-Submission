<?php
require __DIR__.'/auth.php';



use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicIndexController;
use App\Http\Controllers\QuestionDetailsController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================================
// 1) PUBLIC ROUTES
// ============================================================================

Route::get('/', [PublicIndexController::class, 'landing'])->name('home');
Route::get('/questions', [PublicIndexController::class, 'index'])->name('index'); // Questions Feed (was index)

Route::get('/question-details/{id}', [QuestionDetailsController::class, 'index'])->name('question-details'); // Using generic for demo, usually /{id}
Route::post('/question-details/{id}/answer', [QuestionDetailsController::class, 'store'])->name('answer.store')->middleware(['auth', 'role:lawyer']);
Route::middleware('auth','role:user')->group(function () {
Route::get('/ask-question',[PublicIndexController::class,'addQuestion'])->name('ask-question');
Route::post('/store-question',[PublicIndexController::class,'storeQuestion'])->name('store-question');
});
Route::view('/lawyers', 'public.lawyers')->name('lawyers');
Route::get('/lawyer-profile/{id}', [PublicIndexController::class, 'lawyerProfile'])->name('lawyer-profile'); 
Route::view('/edit-lawyer-profile', 'public.edit-lawyer-profile')->name('edit-lawyer-profile'); 

Route::get('/blog', [PublicIndexController::class, 'blog'])->name('blog');
Route::get('/article/details/{id}', [PublicIndexController::class, 'articleDetails'])->name('article.details');
Route::view('/my-articles', 'public.my-articles')->name('my-articles');
Route::view('/article/new', 'public.new-article')->name('new-article');
Route::view('/article/edit', 'public.edit-article')->name('edit-article');
Route::get('/search', [PublicIndexController::class, 'search'])->name('search');
Route::post('/replies/{id}/like', [QuestionDetailsController::class, 'likeReply'])->name('replies.like');

// Route::view('/login', 'public.login')->name('login'); // Handled by Breeze in auth.php
// Route::view('/register', 'public.register')->name('register'); // Handled by Breeze in auth.php
Route::get('/lawyer/request', function () {
    $categories = \App\Models\Category::all();
    return view('public.lawyer-request', compact('categories'));
})->name('lawyer-request');

Route::post('/lawyer/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'storeLawyer'])->name('lawyer.register');

// ============================================================================
// 2) ADMIN ROUTES
// Prefix: /admin
// ============================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/dashboard', 'admin.dashboard'); // Alias

    Route::resource('users',  \App\Http\Controllers\Admin\UserController::class);
    Route::view('/lawyer-requests', 'admin.lawyer-requests.index')->name('lawyer-requests');
    Route::view('/questions', 'admin.questions.index')->name('questions');
    Route::view('/articles', 'admin.articles.index')->name('articles');
    Route::view('/categories', 'admin.categories.index')->name('categories');
});

// ============================================================================
// 3) LAWYER ROUTES
// Prefix: /lawyer
// ============================================================================

Route::prefix('lawyer')->name('lawyer.')->middleware(['auth', 'role:lawyer'])->group(function () {
    Route::redirect('/', '/lawyer/dashboard');
    Route::view('/dashboard', 'lawyer.dashboard')->name('dashboard');

    Route::view('/questions', 'lawyer.questions.index')->name('questions.index');

    Route::view('/answers', 'lawyer.answers.index')->name('answers.index');
    Route::view('/answers/{id}/edit', 'lawyer.answers.edit')->name('answers.edit');
    Route::view('/questions/{id}/answer', 'lawyer.answers.create')->name('questions.answer');

    Route::view('/articles', 'lawyer.articles.index')->name('articles.index');
    Route::view('/articles/create', 'lawyer.articles.create')->name('articles.create');
    Route::get('/articles/{id}/edit', function ($id) {
        return view('lawyer.articles.edit', compact('id'));
    })->name('articles.edit');

    Route::view('/profile/edit', 'lawyer.profile.edit')->name('profile.edit');
});
