@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/pages/profile.css") }}">

@section('main-content')
    <div class="profile-container flex-column">
        @include('objects.profiles.full_profile', ['user' => $user, "profile" => $profile])
        <div class="profile-posts-container float">

            @auth()
                <div class="new-post flex-row" style="justify-content: space-between">
                    <img src="{{ \App\Models\User::AuthUser()->profile()->profilePicture() }}" alt="pfp"
                    style="width: 64px; height: 64px; border-radius: 25%">
                    <form class="flex-column" method="post" style="align-items: center" action="{{ route('profileposts.store') }}">
                        @csrf
                        <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                        <textarea id="message" name="message" cols="80" rows="5" style="border-radius: 1rem; padding: 1rem; background: var(--background)"></textarea>
                        <input type="submit" value="Post"
                               style="background: var(--primary); border: none; border-radius: 20px; padding: 5px 15px 5px 15px; width: fit-content; margin-top: 10px">
                    </form>
                </div>
            @endauth



            @foreach($profile->getProfilePosts() as $post)
                @include('objects.profiles.profile_post', ['post' => $post])
            @endforeach
        </div>
    </div>

@endsection
