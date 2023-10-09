
<style>

    .blue-border {
        width: auto; /* Adjust the width as needed */
        height: auto; /* Adjust the height as needed */
        border: 2px solid blue; /* Creates a golden border */
    }
</style>

<div class="comment blue-border">
    <h3>By {{ $post->user->name }}</h3>
    <p>{{ $comment->content }}</p>
    <p>{{ $comment->created_at }}</p>
</div>
