
<div class="comment">
    <div class="post-top">
        <h3 class="post-title">By {{ $post->user->name }}</h3>
        <p class="creation-date">{{ $comment->created_at }}</p>
    </div>
    <p class="post-content">{{ $comment->content }}</p>
</div>
