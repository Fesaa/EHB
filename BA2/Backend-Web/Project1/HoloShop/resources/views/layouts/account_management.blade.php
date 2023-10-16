@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/layouts/account_management.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container">

        <div class="options float">
            <ul>
                @php
                $user = \App\Models\User::AuthUser();
                $profile = $user->profile();
                @endphp
                <li class="options-list-section"><a class="clean-link" href="{{ route('users.show', $user->id) }}">YOUR ACCOUNT</a></li>
                <li><a href="{{ route('profiles.show', $profile->id) }}">Your profile</a></li>
                <li><a>Your posts</a></li>
                <li class="options-list-section"><a class="clean-link" href="{{ route('users.show', $user->id) }}">SETTINGS</a></li>
                <li><a href="{{ route('users.edit',$user->id) }}">Security</a></li>
                <li><a href="{{ route('profiles.edit', ["profile" => $profile->id]) }}">Profile</a></li>
                <li><a>Preferences</a></li>
                <li><a href="{{ route('logout') }}">Log out</a></li>
            </ul>
        </div>

        <div class="full-flex">
            @yield('form')
        </div>
    </div>
@endsection
