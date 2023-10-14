<link rel="stylesheet" href="{{ asset("css/objects/profiles/full_profile.css") }}">

<div class="flex-column">
    <div class="profile-full flex-row float {{ $user->isStaff() ? "staff-border" : "" }}"
    style="background-image: url({{ $profile->bannerPicture() }})"
    >
        <img class="profile-image" src="{{ $profile->profilePicture() }}" alt="IMAGE">

        <div class="profile-info-container flex-column">
            <div class="flex-row">
                <p class="profile-float"
                   style="align-self: flex-start">
                    {{ $user->name }} ({{ $profile->pronouns }})
                    @if($profile->location != null)
                        · {{ $profile->location }}
                    @endif
                </p>
                <p class="profile-float"
                   style="align-self: flex-start; color: {{ $user->colour() }}; font-weight: bolder">
                    {{ $profile->title() }}</p>
            </div>

            <div class="profile-info flex-row profile-float">
                <p>Birthday {{ $profile->birthday->format("d/m/o") }}</p>
                <p>Joined: {{ $user->created_at->format("d/m/o") }}</p>
                <p>Total Posts: 7</p>
                @if($user->isAuth())
                    <a href="{{ route('account.profile') }}" class="edit-btn">Edit Profile</a>
                @endif
            </div>
        </div>

    </div>

    <div class="about-me float">
        <h2>About {{ $user->name }}</h2>
        <p>{{ $profile->bio }}</p>
    </div>


</div>
