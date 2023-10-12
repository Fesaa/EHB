@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/layouts/account_management.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container">

        <div class="options float">
            <ul>
                <li class="options-list-section"><a class="clean-link" href="{{ route('account') }}">YOUR ACCOUNT</a></li>
                <li><a href="{{ route('profile.own') }}">Your profile</a></li>
                <li><a>Your posts</a></li>
                <li class="options-list-section"><a class="clean-link" href="{{ route('account') }}">SETTINGS</a></li>
                <li><a>Security</A></li>
                <li><a href="{{ route('account.profile') }}">Profile</a></li>
                <li><a>Preferences</a></li>
                <li><a href="{{ route('logout') }}">Log out</a></li>
            </ul>
        </div>

        <div class="full-flex">
            @yield('form')
        </div>
    </div>
@endsection
