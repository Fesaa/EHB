@php
    use App\Helper\Formatter;
@endphp
<link rel="stylesheet" href="{{ asset('css/objects/forums/thread_preview.css') }}">

<div class="float flex-row thread-preview">
    <div class="thread-preview-info flex-row">
        @php
            $owner = $thread->owner();
            $profile = $owner->profile();
        @endphp
        <img src="{{ $profile->profilePicture() }}"  alt="threads-image">
        <div class="flex-column">
            <div class="thread-preview-title">
                <a class="coloured-link" href="{{ route('threads.show', ["thread" => $thread->id]) }}">
                    {{ $thread->title }}
                </a>
            </div>
            <div class="thread-preview-desc">
                <a class="coloured-link" href="{{ route('profiles.show', ["profile" => $owner->id]) }}"> {{ $owner->name }}</a>
                - {{ Formatter::date($thread->created_at) }}
            </div>
        </div>
    </div>
    @php
        $post = $thread->getLatestPost();
        if ($post == null) {
            $post = $thread;
        }
        $owner = $post->owner();
        $profile = $owner->profile();
    @endphp
    <div class="thread-preview-info flex-row">
        <div class="flex-column">
            <div>Replies: <strong> {{ $thread->replyCount() }} </strong> </div>
            <div>Views: <strong> {{ $thread->viewCount() }} </strong></div>
        </div>
        <div style="padding-left: 5em" class="flex-column">
            <div>{{ Formatter::timeAgo($post->created_at) }} <br></div>
            <div><a class="coloured-link" href="{{ route('profiles.show', $owner->id) }}"> {{ $owner->name }}</a></div>
        </div>
        <img src="{{ $profile->profilePicture() }}" alt="pfp">
    </div>
</div>
