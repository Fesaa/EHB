<link rel="stylesheet" href="{{ asset('css/objects/forums/forum_preview.css') }}">

<div class="float flex-row">
    <div class="forum-preview-info flex-row">
        <img src="{{ $forum->getImage() }}"  alt="forums-image">
        <div class="flex-column">
            <div class="forum-preview-title">
                <a class="coloured-link" href="{{ route('forum.page', ["id" => $forum->id]) }}">
                    {{ $forum->title }}
                </a>
            </div>
            <div class="forum-preview-desc">
                {{ $forum->getDescription() }}
            </div>
        </div>
    </div>


</div>
