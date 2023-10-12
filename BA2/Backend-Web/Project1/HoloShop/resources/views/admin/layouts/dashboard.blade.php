@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container">

        <div class="options float">
            <ul>
                <li class="options-list-section">HOLOSHOP</li>
                <li><a href="">Roles</a></li>
                <li><a>Privileges</a></li>
                <li><a>Logs</a></li>
                <li><a>Featured content</a></li>
                <li class="options-list-section">MEMBER MANAGEMENT</li>
                <li><a>Members</A></li>
                <li><a href="">Moderation</a></li>
            </ul>
        </div>

        <div class="full-flex">
            @yield('dashboard-content')
        </div>
    </div>
@endsection
