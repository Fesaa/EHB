<link rel="stylesheet" href="{{ asset("css/objects/full_profile.css") }}">

<div class="flex-column">
    <div class="profile-full flex-row float {{ $user->isStaff() ? "staff-border" : "" }}"
    style="background-image: url({{ $profile->getBannerPicture() }})"
    >
        <div class="profile-image">
            <img src="{{ $profile->getProfilePicture() }}" alt="IMAGE">
        </div>

        <div class="profile-info flex-row">
            <p>{{ $user->name }} ({{ $profile->pronouns }})</p>
            <p>Birthday: {{ $profile->birthday->format("d/m/o") }}</p>
            <p>Joined: {{ $user->created_at->format("d/m/o") }}</p>
            <p>Total Posts: 7</p>
            @if($user->isAuth())
                <a href="{{ route('account.profile') }}" class="edit-btn">Edit Profile</a>
            @endif
        </div>
    </div>

    <div class="about-me float">
        <h2>About Me</h2>
        <p>{{ $profile->bio }}</p>
    </div>


</div>