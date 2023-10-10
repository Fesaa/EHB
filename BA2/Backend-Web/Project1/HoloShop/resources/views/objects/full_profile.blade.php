<link rel="stylesheet" href="{{ asset("css/objects/full_profile.css") }}">

<div class="flex-column">
    <div class="profile-full flex-row float {{ $user->isStaff() ? "staff-border" : "" }}">
        <div class="profile-image">
            <img src="https://forums.cubecraftcdn.com/xenforo/data/avatars/o/224/224741.jpg?1695386528" alt="IMAGE">
        </div>

        <div class="profile-info flex-row">
            <p>{{ $user->name }} (She/Her)</p>
            <p>Birthday: 1/1/2003</p>
            <p>Joined: 1/1/2021</p>
            <p>Total Posts: 7</p>
            @if($user->isAuth())
                <a href="{{ route('home') }}" class="edit-btn">Edit Profile</a>
            @endif
        </div>
    </div>

    <div class="about-me float">
        <h2>About Me</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>


</div>
