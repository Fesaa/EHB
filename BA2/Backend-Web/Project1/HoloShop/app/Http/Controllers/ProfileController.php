<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(int $id) {
        $user = User::where(["id" => $id])->first();
        if ($user == null) {
            return redirect('/404');
        }

        return view('pages.profile', [
            'user' => $user,
            'profile' => $user->getProfile()
        ]);
    }

    public function own() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        return $this->show(auth()->user()->id);
    }

    public function members() {
        $users = User::all();
        return view('pages.members', [
            'users' => $users
        ]);
    }

    public function edit() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        return view('pages.forms.edit_profile', [
            'user' => auth()->user(),
            'profile' => auth()->user()->getProfile()
        ]);
    }

    public function update() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        validator(request()->all(), [
            'name' => 'nullable|min:4|max:25',
            'pronouns' => 'nullable|min:4|max:25',
            'aboutme' => 'nullable|min:4|max:255',
            'birthday' => 'nullable|date',
        ])->validate();

        $user = auth()->user();
        $name = request()->get('name');
        if ($name != null) {
            $user->name = request()->get('name');
            $user->save();
        }

        $pronouns = request()->get('pronouns');
        $aboutme = request()->get('aboutme');
        $birthday = request()->get('birthday');

        $profile = $user->profile()->first();
        if ($profile == null) {
            $profile = new Profile();
        }

        if ($pronouns != null) {
            $profile->pronouns = $pronouns;
        }

        if ($aboutme != null) {
            $profile->bio = $aboutme;
        }

        if ($birthday != null) {
            $profile->birthday = $birthday;
        }

        $user->profile()->save($profile);

        return redirect('/profile');

    }
}
