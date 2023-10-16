<style>

    .profile-post-div {
        flex: 1;

        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .profile-post-div > img {
        width: 64px;
        height: 64px;
        border-radius: 25%;
    }

    .profile-post-content {
        margin-left: 30px;
    }

    .profile-post-text {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .profile-link {
        text-decoration: none;
    }

    .profile-link:hover {
        text-decoration: underline;
        color: {{ $post->owner()->colour() }};
    }

    .profile-post-reply-div {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        padding: 1rem;
        margin: 1rem;
    }

    .profile-post-reply-div > img {
        width: 32px;
        height: 32px;
        border-radius: 25%;
    }

</style>

<div class="profile-post-div flex-row">
    <img src="{{ $post->owner()->profile()->profilePicture() }}" alt="pfp">
    <div class="profile-post-content flex-column full-flex">
        <div class="flex-row">
            <a class="profile-link" href="{{ route('profiles.show', $post->owner()->profile()->id) }}">{!!  $post->owner()->colouredName() !!}</a>
            <div style="margin-left: 5px; font-size: smaller">
                 {{ \App\Helper\Formatter::timeAgo($post->created_at) }}
            </div>
        </div>
        <div class="profile-post-text">{{ $post->content() }}</div>
        <div class="profile-post-replies">
            @foreach($post->getReplies() as $reply)
                <div class="profile-post-reply-div flex-row">
                    <img src="{{ $reply->owner()->profile()->profilePicture() }}" alt="pfp">
                    <div class="profile-post-content flex-column">
                        <div class="flex-row">
                            <a class="profile-link" href="{{ route('profiles.show', $reply->owner()->profile()->id) }}">{!!  $reply->owner()->colouredName() !!}</a>
                            <div style="margin-left: 5px; font-size: smaller">
                                {{ \App\Helper\Formatter::timeAgo($reply->created_at) }}
                            </div>
                        </div>
                        <div class="profile-post-text">{{ $reply->content() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

