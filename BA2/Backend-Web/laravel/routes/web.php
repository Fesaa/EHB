<?php

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

global $bookSets;
$bookSets = array(
    1 => array(
        "name" => "Magical World Adventure Book Set",
        "description" => "Embark on a thrilling journey with this enchanting book set filled with magical creatures, daring quests, and epic adventures. Perfect for young readers who love to escape into the world of fantasy and imagination."
    ),
    2 => array(
        "name" => "Fantasy Chronicles: The Quest Begins",
        "description" => "Join the heroes in this epic saga as they embark on a perilous quest to save the kingdom from an ancient evil. Filled with magic, mystery, and unforgettable characters, this book set is a must-read for fantasy lovers."
    ),
    3 => array(
        "name" => "Enchanted Forest Tales",
        "description" => "Explore the secrets of the enchanted forest in this captivating book set. Meet mystical creatures, solve riddles, and uncover the hidden wonders of this magical realm. Perfect for young adventurers."
    ),
    4 => array(
        "name" => "Wizards and Wonders: The Complete Collection",
        "description" => "Dive into the world of wizards, spells, and enchantments with this complete collection of magical adventures. Join young wizards on their journey to discover the true power of magic."
    ),
    5 => array(
        "name" => "Dragons and Destiny: The Legendary Saga",
        "description" => "Experience the thrill of dragon-riding and the challenges of destiny in this legendary saga. Follow the chosen heroes as they battle dragons and unlock their true potential."
    )
);

Route::prefix('')->group(function () {
    Route::get('/', function () {
        global $bookSets;
        return view('content/index', ["booksets" => $bookSets]);
    })->name("index");

    Route::get("/about", function () {
        return view("other/about");
    })->name("about");

    Route::get("/item/{id}", function (int $id) {
        global $bookSets;
        return view("content/item", ["id" => $id, "info" => $bookSets[$id]]);
    })->name("item");
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        global $bookSets;
        $id = rand(1, sizeof($bookSets));
        return view('admin/index', ["search" => $bookSets[$id], "id" => $id]);
    })->name("admin-index");

    Route::get('/create', function () {
        return view('admin/create');
    })->name("admin-create");

    Route::get('/edit/{id}', function (int $id) {
        global $bookSets;
        return view('admin/edit', ["id" => $id, "info" => $bookSets[$id]]);
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
        global $bookSets;
        return redirect()->route("admin-index")
            ->with("id", sizeof($bookSets) + 1)
            ->with("name", $validated["name"])
            ->with("description", $validated["description"]);
    })->name("admin-new");
});
