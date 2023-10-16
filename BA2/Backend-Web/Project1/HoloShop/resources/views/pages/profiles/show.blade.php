@extends('layouts.master')

<link rel="stylesheet" href="{{ asset("css/pages/profile.css") }}">

@section('main-content')
    <div class="profile-container flex-column">
        @include('objects.profiles.full_profile', ['user' => $user, "profile" => $profile])

        <div class="profile-posts-container float">
            <p>Placeholder for profile posts</p>
        </div>

    </div>

@endsection