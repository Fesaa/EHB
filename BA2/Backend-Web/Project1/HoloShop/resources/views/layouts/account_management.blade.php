@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/layouts/account_management.css") }}">

@section('main-content')
    <div class="flex-row account-container">

        <div class="account-options float">
            <ul>
                <li class="account-options-list-section">YOUR ACCOUNT</li>
                <li><a href="{{ route('profile.own') }}">Your profile</a></li>
                <li><a>Your posts</a></li>
                <li class="account-options-list-section">SETTINGS</li>
                <li><a>Security</A></li>
                <li><a href="{{ route('account.profile') }}">Profile</a></li>
                <li><a>Preferences</a></li>
                <li><a href="{{ route('logout') }}">Log out</a></li>
            </ul>
        </div>

        <div class="account-form">
            @yield('form')
        </div>
    </div>
@endsection
