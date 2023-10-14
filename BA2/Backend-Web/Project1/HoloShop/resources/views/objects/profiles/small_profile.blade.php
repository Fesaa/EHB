<link rel="stylesheet" href="{{ asset("css/objects/profiles/small_profile.css") }}">

<div class="small-profile flex-column float
{{ $member->isStaff() ? "staff-border" : "" }}">
    <img src="{{ $profile->profilePicture() }}" alt="IMAGE">
    <a href="{{ route('profile.show', $member->id) }}" class="small-profile-name float btn">{{ $member->name }}</a>
    <p style="color: {{ $member->colour() }}">{{ $profile->title() }}</p>
</div>
