<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return view('pages.account.dashboard');
    }
}
