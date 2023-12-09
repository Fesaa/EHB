@php
    /**
     * @var \App\Models\ProfilePost $post
     */
    $user = $post->owner();
@endphp

<link rel="stylesheet" href="{{ asset("css/objects/profiles/mini_profile.css") }}">

<div class="mini-profile flex-row" style="border-bottom: 1px solid var(--secondary); padding: 10px">
    <img src="{{ $user->profile()->profilePicture() }}" alt="profile picture">
    <div class="mini-profile-content flex-column">
        <div class="mini-profile-name flex-row" style="font-size: xx-small">
            <a class="clean-link" href="{{ route('profiles.show', $user->id) }}">{!! $user->colouredName() !!}</a>
            @php($recipient = $post->owningProfile()->owningUser())
            <span class="flex-row"> &nbsp; > &nbsp;</span>
            <a class="clean-link" href="{{ route('profiles.show', $recipient->id) }}">{!! $recipient->colouredName() !!}</a>

        </div>
        <div class="mini-profile-title">
            {!! $post->content() !!}
        </div>
    </div>
</div>
