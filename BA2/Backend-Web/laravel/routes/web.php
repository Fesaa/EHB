<?php

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

Route::prefix('')->group(function () {
    Route::get('/', function () {
        return view('content/index');
    })->name("index");

    Route::get("/about", function () {
        return view("other/about");
    })->name("about");
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin/index');
    })->name("admin-index");

    Route::get('/create', function () {
        return view('admin/create');
    })->name("admin-create");

    Route::get('/edit', function () {
        return view('admin/edit');
    })->name("admin-edit");
});
