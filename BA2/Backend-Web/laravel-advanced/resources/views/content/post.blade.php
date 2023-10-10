<div class="post">
    <div class="post-top">
        <h3 class="post-title">{{ $post->title }} by {{ $post->user->name }}</h3>
        <p class="creation-date">{{ $post->created_at }}</p>
    </div>
    <p class="post-content">{{ $post->content }}</p>

    <div style="display: flex; justify-content: center">
        <input type="checkbox" id="show-comments-{{ $post->id }}" class="show-comments-checkbox">
        <label for="show-comments-{{ $post->id }}" class="show-comments-button">Show Comments</label>
    </div>

    <div id="comment-container-{{ $post->id }}" class="comment-container" style="display: none">
        @foreach(\App\Models\Comment::where('post_id', $post->id)->get() as $comment)
            <div style="display: flex; justify-content: center">
                @include('content.comment', $comment)
            </div>
        @endforeach
        @auth()
                <form method="post" action="{{ route('new-comment') }}" class="post-comment">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <textarea placeholder="Write a comment" name="content"></textarea>
                    <input type="submit" value="Post">
                </form>
        @endauth
            @guest()
                <div class="post-comment">
                    <a href="{{ route('login') }}">Login to post a comment</a>
                </div>
            @endguest
    </div>
</div>

<script>
    checkbox = document.getElementById('show-comments-{{ $post->id }}')
    checkbox.addEventListener(('change'), function() {
        const commentContainer = document.getElementById('comment-container-{{ $post->id }}')
        commentContainer.style.display = this.checked ? 'block' : 'none';
    })
</script>
