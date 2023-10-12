@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/layouts/logs.css") }}">


@section('dashboard-content')

    <div class="flex-row options-container">
        <div class="options float">
           <ul>
               <li class="options-list-section"><a>LOGS</a></li>
               @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('LOGS_LOGIN')))
                   <li><a href="{{ route('admin.logs.login') }}">Login</a></li>
               @endif
               @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('LOGS_ACTIVITY')))
                   <li><a href="{{ route('admin.roles') }}">Activity</a></li>
               @endif
               @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('LOGS_MODERATION')))
                   <li><a href="{{ route('admin.roles') }}">Moderation</a></li>
               @endif
               @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue('LOGS_POSTS')))
                   <li><a href="{{ route('admin.roles') }}">Posts</a></li>
               @endif
               <li class="options-list-section"><a href="{{ route('admin.dashboard') }}">BACK</a></li>
           </ul>
        </div>
        <div class="full-flex" style="padding: 2em">
            @yield('logs-content')
        </div>
    </div>


@endsection
