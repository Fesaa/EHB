<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::getItems(); // Roep de 'getItems' methode van het Item-model aan.

        return view('items.index', ['items' => $items]); // Geef de lijst met items door aan de weergavepagina.
    }
}
