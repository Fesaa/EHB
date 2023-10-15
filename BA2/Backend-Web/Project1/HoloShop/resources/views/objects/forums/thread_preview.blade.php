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
                <a class="coloured-link" href="{{ route('forum.thread', ["id" => $thread->id]) }}">
                    {{ $thread->title }}
                </a>
            </div>
            <div class="thread-preview-desc">
                <a class="coloured-link" href="{{ route('profile.show', ["id" => $owner->id]) }}"> {{ $owner->name }}</a>
                - {{ Formatter::date($thread->created_at) }}
            </div>
        </div>
    </div>

    @php
        $post = $thread->getLatestPost();
    @endphp
    @if($post != null)
        @php
            $owner = $post->owner();
            $profile = $owner->profile();
        @endphp
        <div class="thread-preview-info flex-row">
            <img src="{{ $profile->profilePicture() }}" alt="pfp">
            <div class="flex-column">
                <div class="thread-preview-title limit-chars">
                    <a class="coloured-link" href="">
                        {{ $post->title }}
                    </a>
                </div>
                <div class="thread-preview-desc">
                    {{ Formatter::timeAgo($post->created_at) }} -
                    <a class="coloured-link" href="{{ route('profile.show', ["id" => $owner->id]) }}"> {{ $owner->name }}</a>
                </div>
            </div>
        </div>
    @endif


</div>
