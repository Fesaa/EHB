<link rel="stylesheet" href="{{ asset("css/objects/profiles/mini_profile.css") }}">

<div class="mini-profile flex-row">
    <img src="{{ $user->profile()->profilePicture() }}" alt="profile picture">
    <div class="mini-profile-content flex-column">
        <div class="mini-profile-name">
            <a class="clean-link" href="{{ route('profile.show', $user->id) }}">{!! $user->colouredName() !!}</a>
        </div>
        <div class="mini-profile-title">
            {{ $user->profile()->title }}
        </div>
    </div>
</div>
