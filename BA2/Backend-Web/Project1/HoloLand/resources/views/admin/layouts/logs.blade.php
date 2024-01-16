@php
    use App\Models\User;
    use App\Models\Privilege;
@endphp
@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/layouts/logs.css") }}">


@section('dashboard-content')

    <div class="flex-row options-container">
        <div class="options float">
            <ul>
                <li class="options-list-section"><a href="{{ route('admin.logs') }}">LOGS</a></li>
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('LOGS_LOGIN')))
                    <li><a href="{{ route('admin.logs.login') }}">Login</a></li>
                @endif
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('LOGS_ACTIVITY')))
                    <li><a href="{{ route('admin.logs.activity') }}">Activity</a></li>
                @endif
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('LOGS_MODERATION')))
                    <li><a href="">Moderation</a></li>
                @endif
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('LOGS_POSTS')))
                    <li><a href="{{ route('admin.logs.posts.thread') }}">Thread Posts</a></li>
                    <li><a href="{{ route('admin.logs.posts.profile') }}">Profile Posts</a></li>
                    <li><a href="{{ route('admin.logs.threads') }}">Threads</a></li>
                    <li><a href="{{ route('admin.logs.forums') }}">Forums</a></li>
                @endif
                <li class="options-list-section"><a href="{{ route('admin.dashboard') }}">BACK</a></li>
            </ul>
        </div>
        <div class="full-flex" style="padding: 2em">
            @yield('logs-content')
        </div>
    </div>

@endsection
