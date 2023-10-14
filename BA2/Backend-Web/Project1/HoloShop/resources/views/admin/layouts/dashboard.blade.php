@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container" id="admin-dashboard">

        <div class="options float" id="admin-dashboard-menu">
            <ul>
                <li class="options-list-section"><a class="clean-link"
                                                    href="{{ route('admin.dashboard') }}">HOLOSHOP</a></li>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_ROLES')))
                    <li><a href="{{ route('admin.roles') }}">Roles</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_PRIVILEGES')))
                    <li><a href="{{ route('admin.privileges') }}">Privileges</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_LOGS')))
                    <li><a href="{{ route('admin.logs') }}">Logs</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_FEATURED')))
                    <li><a>Featured content</a></li>
                @endif
                <li class="options-list-section"><a class="clean-link"
                                                    href="{{ route('admin.dashboard') }}">MODERATION</a></li>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_MEMBERS')))
                    <li><a href="{{ route('admin.members') }}">Members</A></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::privilegeValueOf('DASHBOARD_PUNISHMENTS')))
                    <li><a href="">Punishments</a></li>
                @endif
            </ul>
        </div>

        <div class="full-flex" id="dashboard-content">
            @yield('dashboard-content')
        </div>
    </div>
@endsection
