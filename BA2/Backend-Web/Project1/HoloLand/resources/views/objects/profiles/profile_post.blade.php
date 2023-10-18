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

@php
/** @var \App\Models\ProfilePost $post */
@endphp

<div class="profile-post-div flex-row">
    <img src="{{ $post->owner()->profile()->profilePicture() }}" alt="pfp">
    <div id="profile-post-{{$post->id}}" class="profile-post-content flex-column full-flex">
        <div class="flex-row" style="justify-content: space-between">
            <div class="flex-row">
                <a class="profile-link" href="{{ route('profiles.show', $post->owner()->profile()->id) }}">{!!  $post->owner()->colouredName() !!}</a>
                @if($recipient)
                    <span class="flex-row"> &nbsp; > &nbsp; {!! $post->owningProfile()->owningUser()->colouredName() !!}</span>
                @endif
            </div>
            <div style="margin-left: 5px; font-size: smaller">
                 <a class="clean-link" href="#profile-post-{{$post->id}}">{{ \App\Helper\Formatter::timeAgo($post->created_at) }}</a>
            </div>
        </div>
        <div class="profile-post-text">{!!  $post->content() !!}</div>
        <div class="profile-post-replies">
            @foreach($post->getReplies() as $reply)
                <div id="profile-post-{{$reply->id}}" class="profile-post-reply-div flex-row">
                    <img src="{{ $reply->owner()->profile()->profilePicture() }}" alt="pfp">
                    <div class="profile-post-content flex-column full-flex">
                        <div class="flex-row full-flex" style="justify-content: space-between">
                            <a class="profile-link" href="{{ route('profiles.show', $reply->owner()->profile()->id) }}">{!!  $reply->owner()->colouredName() !!}</a>
                            <div style="margin-left: 5px; font-size: smaller">
                                <a class="clean-link" href="#profile-post-{{$reply->id}}">{{ \App\Helper\Formatter::timeAgo($reply->created_at) }}</a>
                            </div>
                        </div>
                        <div class="profile-post-text">{!! $reply->content() !!}</div>
                    </div>
                </div>
            @endforeach
                @if($postBox)
                    <div class="new-post flex-row profile-post-content" style="margin-top: 1em">
                        <img src="{{ \App\Models\User::AuthUser()->profile()->profilePicture() }}" alt="pfp"
                             style="width: 32px; height: 32px; border-radius: 25%">
                        <form class="flex-column" method="post" style="flex: 1; margin: 0 1em 0 1em" action="{{ route('profileposts.store') }}">
                            @csrf
                            <input type="hidden" name="profile_id" value="{{ $post->profile_id }}">
                            <input type="hidden" name="profilepost_id" value="{{ $post->id }}">
                            <textarea id="message" name="message" cols="80" rows="2" style="border-radius: 1rem; padding: 1rem; background: var(--background);"></textarea>
                            <div class="flex-row" style="justify-content: center">
                                <input type="submit" value="Post" style="background: var(--primary); border: none; border-radius: 20px; padding: 5px 15px 5px 15px; width: fit-content; margin-top: 10px">
                            </div>
                        </form>
                    </div>
                @endif
        </div>
    </div>
</div>

