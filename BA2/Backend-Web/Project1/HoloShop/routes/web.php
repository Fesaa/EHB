<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::get('/404', function() {
    return view('pages.404');
})->name('404');

// Profile routes
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/members', [ProfileController::class, 'members'])->name('members');
Route::get('/profile', [ProfileController::class, 'own'])->name('profile.own');

// Account
Route::get('/account/profile', [ProfileController::class, 'edit'])->name('account.profile');
Route::post('/account/profile', [ProfileController::class, 'update'])->name('account.profile.update');

// Auth routes
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('register', [AuthController::class, 'register']);
Route::get('register', [AuthController::class, 'showRegister'])->name('register');

// Admin routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
