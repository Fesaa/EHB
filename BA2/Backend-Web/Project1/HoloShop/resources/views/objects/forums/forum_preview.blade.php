@php
    /**
     * @var \App\Models\Forum $forum
     */
    use App\Helper\Formatter;
@endphp
<link rel="stylesheet" href="{{ asset('css/objects/forums/forum_preview.css') }}">

<div class="float flex-row forum-preview">
    <div class="forum-preview-info flex-row">
        <img src="{{ $forum->image() }}"  alt="forums-image">
        <div class="flex-column">
            <div class="forum-preview-title">
                <a class="coloured-link" href="{{ route('forums.show', ["forum" => $forum->id]) }}">
                    {{ $forum->title }}
                </a>
            </div>
            <div class="forum-preview-desc">
                {!! $forum->subtitle() !!}
            </div>
        </div>
    </div>

    @php
    $thread = $forum->getLatestThread();
    @endphp
    @if($thread != null)
        @php
            $owner = $thread->owner();
            $profile = $owner->profile();
        @endphp
        <div class="forum-preview-info flex-row">
            <img src="{{ $profile->profilePicture() }}" alt="pfp">
            <div class="flex-column">
                <div class="forum-preview-title limit-chars">
                    <a class="coloured-link" href=" {{ route('threads.show', ["thread" => $thread->id]) }}">
                        {{ $thread->title }}
                    </a>
                </div>
                <div class="forum-preview-desc">
                    {{ Formatter::timeAgo($thread->created_at) }} -
                    <a class="coloured-link" href="{{ route('profile.show', ["id" => $owner->id]) }}"> {{ $owner->name }}</a>
                </div>
            </div>
        </div>
    @endif
</div>
