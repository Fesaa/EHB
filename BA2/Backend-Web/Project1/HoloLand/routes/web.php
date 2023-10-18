<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isStaff;
use App\Models\ProfilePost;
use \App\Models\Thread;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|Be careful as changing some may have lasting impact!


*/

Route::get('/', function () {
    return view('pages.index', [
        'featuredThreads' => Thread::featuredThreads(),
        'newsThreads' => Thread::newsThreads(),
    ]);
})->name('home');

Route::get('/whatsnew', function () {
    return view('pages.whatsnew', [
        'threads' => Thread::recentThreads(),
        'posts' => ProfilePost::recentPosts(),
    ]);
})->name('whatsnew');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/404', function() {
    return view('pages.status.404');
})->name('404');


Route::resource('forums', ForumController::class);
Route::resource('threads', ThreadController::class)->except(['index']);
Route::resource('posts', PostController::class)->except(['index', 'create', 'show']);
Route::resource('profileposts', ProfilePostController::class)->except(['index', 'create', 'edit', 'update']);
Route::resource('profiles', ProfileController::class)->except(['index', 'create', 'destroy']);
Route::resource('users', UserController::class);
Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.handle');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/ban', [UserController::class, 'ban'])->name('ban');

// Admin routes
Route::prefix('/admin')
    ->middleware(isStaff::class)
    ->name('admin.')
    ->group(function() {
        Route::resource('roles', RoleController::class)
            ->except([
                'create',
                'show',
                'edit',
            ]);




        Route::get('', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/privileges', [AdminController::class, 'privileges'])->name('privileges');
        Route::post('/privileges', [PrivilegeController::class, 'handle'])->name('hololand.privileges.update');



        Route::get('/members', [AdminController::class, 'members'])->name('members');
        Route::get('/members/edit/{id}', [ProfileController::class, 'edit_other'])->name('members.edit');
        Route::post('/members/roles/edit', [AdminController::class, 'update_roles'])->name('members.edit.roles.update');

        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        Route::get('/logs/login', [LogController::class, 'login'])->name('logs.login');
        Route::get('/logs/activity', [LogController::class, 'activity'])->name('logs.activity');
        Route::get('/logs/posts/thread', [LogController::class, 'threadPosts'])->name('logs.posts.thread');
        Route::get('/logs/posts/profile', [LogController::class, 'profilePosts'])->name('logs.posts.profile');
        Route::get('/logs/threads', [LogController::class, 'threads'])->name('logs.threads');
        Route::get('/logs/forums', [LogController::class, 'forums'])->name('logs.forums');
    });
