<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;

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

    private function getAssetIdAndSave(UploadedFile $file): int {
        $data = base64_encode(file_get_contents($file));
        $asset = Asset::where(["data" => $data])->first();
        if ($asset == null) {
            $asset = new Asset();
            $asset->data = $data;
            $asset->save();
        }
        return (int) $asset->id;
    }

    private function getAssetIdAndStore(string $url): int {
        $asset = Asset::where(["url" => $url])->first();
        if ($asset == null) {
            $asset = new Asset();
            $asset->data = $url;
            $asset->save();
        }
        return (int) $asset->id;
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
            'pfp-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:1024',
            'banner-file' => 'nullable|file|mimes:jpeg,png,gif,webp|max:2048',
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
        $pfp_url = request()->get('pfp-url');
        $pfp_file = request()->file('pfp-file');
        $banner_url = request()->get('banner-url');
        $banner_file = request()->file('banner-file');

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

        if ($pfp_url != null) {
            $profile->pfp_asset_id = $this->getAssetIdAndStore($pfp_url);
        } elseif ($pfp_file != null) {
            $profile->pfp_asset_id = $this->getAssetIdAndSave($pfp_file);
        }

        if ($banner_url != null) {
            $profile->banner_asset_id = $this->getAssetIdAndStore($banner_url);
        } elseif ($banner_file != null) {
            $profile->banner_asset_id = $this->getAssetIdAndSave($banner_file);
        }

        $user->profile()->save($profile);

        return redirect('/profile');

    }
}
