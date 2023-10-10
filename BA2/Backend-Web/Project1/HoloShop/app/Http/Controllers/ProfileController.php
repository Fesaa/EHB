<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(int $id) {
        $user = User::where(["id" => $id])->first();
        if ($user == null) {
            return redirect('/404');
        }


        return view('pages.profile', [
            'user' => $user
        ]);
    }

    public function members() {
        $users = User::all();
        return view('pages.members', [
            'users' => $users
        ]);
    }
}
