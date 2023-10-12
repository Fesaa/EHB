@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container">

        <div class="options float">
            <ul>
                <li class="options-list-section">HOLOSHOP</li>
                <li><a href="{{ route('admin.roles') }}">Roles</a></li>
                <li><a href="{{ route('admin.privileges') }}">Privileges</a></li>
                <li><a href="{{ route('admin.logs') }}">Logs</a></li>
                <li><a>Featured content</a></li>
                <li class="options-list-section">MODERATION</li>
                <li><a>Members</A></li>
                <li><a href="">Punishments</a></li>
            </ul>
        </div>

        <div class="full-flex">
            @yield('dashboard-content')
        </div>
    </div>
@endsection
