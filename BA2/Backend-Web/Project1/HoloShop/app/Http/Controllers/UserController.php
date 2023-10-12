<?php

namespace App\Http\Controllers;

use App\Models\User;
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


    public function members() {
        $users = User::all()->sortBy('created_at');
        return view('pages.members', [
            'users' => $users
        ]);
    }
}
