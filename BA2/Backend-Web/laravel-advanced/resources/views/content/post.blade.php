<style>
    .golden-border {
        width: 200px; /* Adjust the width as needed */
        height: 200px; /* Adjust the height as needed */
        border: 2px solid gold; /* Creates a golden border */
    }

    .post {
        width: auto;
        margin: 50px 50px;
        text-align: center;
    }
</style>

<div class="center golden-border post">
    <h3>{{ $post->title }} by {{ $post->user->name }}</h3>
    <p>{{ $post->content }}</p>
    <p>{{ $post->created_at }}</p>

    @foreach(\App\Models\Comment::where('post_id', $post->id)->get() as $comment)
        @include('content.comment', $comment)
    @endforeach
</div>
