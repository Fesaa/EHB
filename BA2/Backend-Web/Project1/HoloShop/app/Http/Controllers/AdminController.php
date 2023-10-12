<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->isStaff()) {
            return redirect()->route('home');
        }

        return view('admin.pages.index');
    }
}
