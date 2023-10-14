<link rel="stylesheet" href="{{ asset("css/objects/profiles/small_profile.css") }}">

<div class="small-profile flex-column float
{{ $member->isStaff() ? "staff-border" : "" }}"
     @if($user->profile()->isBirthday())
         style="box-shadow: 2px 2px 2px 2px rgba(250, 123, 200, 0.9), 2px 2px 2px 2px rgba(120, 175, 255, 0.9), 2px 2px 2px 2px rgba(255, 211, 101, 0.9);"
    @endif>
    <img src="{{ $profile->profilePicture() }}" alt="IMAGE">
    <a href="{{ route('profile.show', $member->id) }}" class="small-profile-name float btn">{{ $member->name }}</a>
    <p style="color: {{ $member->colour() }}">{{ $profile->title() }}</p>
</div>
