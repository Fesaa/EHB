<link rel="stylesheet" href="{{ asset("css/objects/profiles/mini_profile.css") }}">

<div class="mini-profile flex-row">
    <img src="{{ $user->getProfile()->getProfilePicture() }}" alt="profile picture">
    <div class="mini-profile-content flex-column">
        <div class="mini-profile-name">
            <a class="clean-link" href="{{ route('profile.show', $user->id) }}">{!! $user->getColouredName() !!}</a>
        </div>
        <div class="mini-profile-title">
            {{ $user->getProfile()->title }}
        </div>
    </div>
</div>
