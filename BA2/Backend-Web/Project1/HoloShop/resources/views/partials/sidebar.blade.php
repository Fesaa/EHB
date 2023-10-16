@php
    use App\Models\User;
@endphp
<link href="{{ asset('css/partials/sidebar.css') }}" rel="stylesheet">

<div class="sidebar flex-column float shiny-bg" style="justify-content: space-between">
    <ul>
        <li class="sidebar-button"><a href="{{ route('home') }}">Home</a></li>
        <li class="sidebar-button"><a href="{{ route('whatsnew') }}">What's new</a></li>
        <li class="sidebar-button"><a href="{{ route('forums.index') }}">Forums</a></li>
        <li class="sidebar-button"><a href="{{ route('users.index') }}">Members</a></li>
        <li class="no-hover"></li>
        <li class="no-hover"></li>
        <li class="no-hover"></li>
        @auth()
            <li class="sidebar-button"><a href="{{ route('profiles.show', ["profile" => User::AuthUser()->id]) }}">Profile</a></li>
            <li class="sidebar-button"><a href="{{ route('users.show', User::AuthUser()->id) }}">Account</a> </li>
            @if(User::AuthUser()->isStaff())
                <li class="sidebar-button"><a href="{{ route('admin.dashboard') }}">Staff panel</a></li>
            @endif
        @endauth
    </ul>
</div>
