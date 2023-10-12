@extends('layouts.master')
<link rel="stylesheet" href="{{ asset("css/shared/options.css") }}">

@section('main-content')
    <div class="flex-row options-container">

        <div class="options float">
            <ul>
                <li class="options-list-section">HOLOSHOP</li>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_ROLES')))
                    <li><a href="{{ route('admin.roles') }}">Roles</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_PRIVILEGES')))
                    <li><a href="{{ route('admin.privileges') }}">Privileges</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_LOGS')))
                    <li><a href="{{ route('admin.logs') }}">Logs</a></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_FEATURED')))
                    <li><a>Featured content</a></li>
                @endif
                <li class="options-list-section">MODERATION</li>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_MEMBERS')))
                    <li><a href="{{ route('admin.members') }}">Members</A></li>
                @endif
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('DASHBOARD_PUNISHMENTS')))
                    <li><a href="">Punishments</a></li>
                @endif
            </ul>
        </div>

        <div class="full-flex">
            @yield('dashboard-content')
        </div>
    </div>
@endsection
