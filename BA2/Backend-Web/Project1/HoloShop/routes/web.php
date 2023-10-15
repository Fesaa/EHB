<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadControllerr;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAuthenticated;
use App\Http\Middleware\isStaff;
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
    return view('pages.index');
})->name('home');

Route::get('/404', function() {
    return view('pages.status.404');
})->name('404');


Route::resource('forums', ForumController::class);
Route::resource('threads', ThreadController::class);





// Profile routes
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/members', [UserController::class, 'members'])->name('members');
Route::get('/profile', [ProfileController::class, 'own'])->name('profile.own');

// Account
Route::prefix('/account')
    ->middleware(isAuthenticated::class)
    ->name('account')
    ->group(function() {
    Route::get('/', [UserController::class, 'dashboard'])->name('');

    Route::get('/security', [UserController::class, 'security'])->name('.security');
    Route::post('/security', [UserController::class, 'update'])->name('.security.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('.profile');
    Route::post('/profile', [ProfileController::class, 'handle'])->name('.profile.update');
    });

// Auth routes
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('register', [AuthController::class, 'register']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::get('/ban', [AuthController::class, 'ban'])->name('ban');

// Admin routes
Route::prefix('/admin')
    ->middleware(isStaff::class)
    ->name('admin')
    ->group(function() {
        Route::get('', [AdminController::class, 'index'])->name('.dashboard');

        Route::get('/privileges', [AdminController::class, 'privileges'])->name('.privileges');
        Route::post('/privileges', [PrivilegeController::class, 'handle'])->name('.holoshop.privileges.update');

        Route::get('/roles', [AdminController::class, 'roles'])->name('.roles');
        Route::post('/roles/privileges', [RoleController::class, 'update'])->name('.holoshop.roles.update');

        Route::get('/members', [AdminController::class, 'members'])->name('.members');
        Route::get('/members/edit/{id}', [ProfileController::class, 'edit_other'])->name('.members.edit');
        Route::post('/members/roles/edit', [AdminController::class, 'update_roles'])->name('.members.edit.roles.update');

        Route::get('/logs', [AdminController::class, 'logs'])->name('.logs');
        Route::get('/logs/login', [LogController::class, 'login'])->name('.logs.login');
        Route::get('/logs/activity', [LogController::class, 'activity'])->name('.logs.activity');
    });
