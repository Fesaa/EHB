<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Privilege;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function show(int $id) {
        $user = User::where(["id" => $id])->first();
        if ($user == null) {
            return redirect('/404');
        }

        return view('pages.profile', [
            'user' => $user,
            'profile' => $user->profile()
        ]);
    }

    public function own() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        return $this->show(User::AuthUser()->id);
    }

    public function edit() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        return view('pages.forms.edit_profile', [
            'user' => User::AuthUser(),
            'profile' => User::AuthUser()->profile()
        ]);
    }

    public function edit_other(int $id) {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = User::where(["id" => $id])->first();
        if ($user == null) {
            return redirect('/404');
        }


        if (!User::AuthUser()->canEdit($user)) {
            return redirect('/404');
        }

        return view('pages.forms.edit_profile', [
            'user' => $user,
            'profile' => $user->profile()
        ]);
    }

    public function handle() {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $id = request()->get('id');
        if ($id != null) {
            $id = Crypt::decrypt(request()->get('id'));
            $user = User::where(["id" => $id])->first();
            if ($user == null) {
                return redirect('/404');
            }

            if (!User::AuthUser()->canEdit($user)) {
                return redirect('/404');
            }

            return $this->updateProfile($user);
        }

        $user = User::AuthUser();
        return $this->updateProfile($user);
    }

    public function updateProfile(User $user)
    {
        validator(request()->all(), [
            'name' => 'nullable|min:2|max:25',
            'pronouns' => 'nullable|max:25',
            'aboutme' => 'nullable',
            'birthday' => 'nullable|date',
            'pfp-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:1024',
            'banner-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:2048',
            'title' => 'max:25|nullable',
            'location' => 'max:50|nullable',
        ])->validate();

        $name = request()->get('name');
        if ($name != null) {
            $user->name = request()->get('name');
            $user->save();
        }

        $title = request()->get('title');
        $location = request()->get('location');
        $pronouns = request()->get('pronouns');
        $aboutme = request()->get('aboutme');
        $birthday = request()->get('birthday');
        $pfp_url = request()->get('pfp-url');
        $pfp_file = request()->file('pfp-file');
        $banner_url = request()->get('banner-url');
        $banner_file = request()->file('banner-file');

        $this->update($user, $title, $location, $pronouns, $aboutme, $birthday, $pfp_url, $pfp_file, $banner_url, $banner_file);
        return redirect()->route('profile.show', ['id' => $user->id]);
    }


    private function update(User $user, string|null $title, string|null $location,
                            string|null $pronouns, string|null $aboutme, string|null $birthday,
                            string|null $pfp_url, UploadedFile|null $pfp_file, string|null $banner_url,
                            UploadedFile|null $banner_file): void
    {
        $profile = $user->profile();

        if ($title != null) {
            $profile->title = $title;
        }

        if ($location != null) {
            $profile->location = $location;
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

        if ($pfp_url != null) {
            $profile->pfp_asset_id = Asset::fromURL($pfp_url)->id;
        } elseif ($pfp_file != null) {
            $profile->pfp_asset_id = Asset::fromData($pfp_file)->id;
        }

        if ($banner_url != null) {
            $profile->banner_asset_id = Asset::fromURL($banner_url)->id;
        } elseif ($banner_file != null) {
            $profile->banner_asset_id = Asset::fromData($banner_file)->id;
        }

        $profile->save();
    }
}
