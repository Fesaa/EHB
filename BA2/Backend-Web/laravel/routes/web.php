<?php

use App\Models\Item;
use Illuminate\Http\Request;
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
        return view('content/index', ["booksets" => Item::getBookSets()]);
    })->name("index");

    Route::get("/about", function () {
        return view("other/about");
    })->name("about");

    Route::get("/item/{id}", function (int $id) {
        return view("content/item", ["id" => $id, "info" => Item::getBookSets()[$id]]);
    })->name("item");
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        $id = rand(1, sizeof(Item::getBookSets()));
        return view('admin/index', ["search" => Item::getBookSets()[$id], "id" => $id]);
    })->name("admin-index");

    Route::get('/create', function () {
        return view('admin/create');
    })->name("admin-create");

    Route::get('/edit/{id}', function (int $id) {
        return view('admin/edit', ["id" => $id, "info" => Item::getBookSets()[$id]]);
    })->name("admin-edit");

    Route::post("/update", function(Request $request) {
            $validated = $request->validate([
                "id" => "required|integer",
                "name" => "required|string|max:100",
                "description" => "required|string|min:20"
            ]);
        return redirect()->route("admin-index")
            ->with("id", $validated["id"])
            ->with("name", $validated["name"])
            ->with("description", $validated["description"]);
    })->name("admin-update");


    Route::post("/new", function(Request $request) {
        $validated = $request->validate([
            "name" => "required|string|max:100",
            "description" => "required|string|min:20"
        ]);
        return redirect()->route("admin-index")
            ->with("id", sizeof(Item::getBookSets()) + 1)
            ->with("name", $validated["name"])
            ->with("description", $validated["description"]);
    })->name("admin-new");
});
