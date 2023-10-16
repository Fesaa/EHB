<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::getProfile($id);
        if ($profile == null) {
            return redirect('/404');
        }

        return view('pages.profiles.show', [
            'user' => $profile->owningUser(),
            'profile' => $profile,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::getUser($id);

        if ($user == null) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->canEdit($user)) {
            return redirect()->route('home'); // TODO: Change to not allowed page
        }

        return view('pages.profiles.edit', [
            'user' => User::AuthUser(),
            'profile' => User::AuthUser()->profile()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $user = User::getUser($id);

        if ($user == null) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->canEdit($user)) {
            return redirect()->route('home'); // TODO: Change to not allowed page
        }

        $request->validate([
            'name' => 'nullable|min:2|max:25',
            'pronouns' => 'nullable|max:25',
            'aboutme' => 'nullable',
            'birthday' => 'nullable|date',
            'pfp-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:1024',
            'banner-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:2048',
            'title' => 'max:25|nullable',
            'location' => 'max:50|nullable',
        ]);

        if ($request->get('name') != null) {
            $user->name = $request->get('name');
        }

        $profile = $user->profile();
        $profile->pronouns = $request->get('pronouns');
        $profile->bio = $request->get('aboutme');
        $profile->birthday = $request->get('birthday');
        $profile->title = $request->get('title');
        $profile->location = $request->get('location');

        if ($request->file('pfp-url') != null) {
            $profile->pfp_asset_id = Asset::fromURL($request->file('pfp-url'))->id;
        } elseif ($request->file('pfp-file') != null) {
            $profile->pfp_asset_id = Asset::fromFile($request->file('pfp-file'))->id;
        }

        $user->save();
        $profile->save();
        return redirect()->route('profiles.show', ['profile' => $user->id]);
    }
}
