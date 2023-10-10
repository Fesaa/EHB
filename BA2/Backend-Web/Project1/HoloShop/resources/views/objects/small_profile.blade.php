<link rel="stylesheet" href="{{ asset("css/objects/small_profile.css") }}">

<div class="small-profile flex-column float
{{ $member->isStaff() ? "staff-border" : "" }}">

    <img src="https://forums.cubecraftcdn.com/xenforo/data/avatars/o/224/224741.jpg?1695386528" alt="IMAGE">
    <a href="{{ route('profile.show', $member->id) }}" class="small-profile-name float btn">{{ $member->name }}</a>
</div>
