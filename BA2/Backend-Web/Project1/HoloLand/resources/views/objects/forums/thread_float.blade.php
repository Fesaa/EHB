<link href="{{ asset('css/objects/forums/thread_float.css') }}" rel="stylesheet">

@php
    /** @var \App\Models\User $owner */
    $owner = $thread->owner()
@endphp
<div class="flex-column floating-thread-holder float shiny-bg">
    <div class="flex-row floating-thread-title-row">
        <div class="floating-thread-title"><a class="front-link" href="{{ route("threads.show", $thread->id) }}">{{ $thread->title }}</a></div>
        <div class="flex-row floating-thread-owner">
            <img src="{{ $owner->profile()->profilePicture() }}"  alt="pfp" width="24px" height="24px">
            <div><a class="front-link" href="{{ route('profiles.show', $owner->profile()->id) }}">{{ $owner->name }}</a></div>
            <div>{{ \App\Helper\Formatter::date($thread->created_at) }}</div>
        </div>
    </div>
    <div style="max-height: 250px; text-overflow: ellipsis; overflow: hidden"> {!! $thread->content() !!} </div>
    <div class="floating-thread-footer flex-row">
        <div>Thread - Replies: {{ $thread->replyCount() }}</div>
        <a class="read-more" href="{{ route("threads.show", $thread->id) }}">Read More</a>
    </div>
</div>
