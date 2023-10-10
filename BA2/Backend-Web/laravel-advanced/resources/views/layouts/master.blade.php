<link rel="stylesheet" href="{{ asset("css/main.css") }}">
<script>let checkbox</script>
<h1 class="center">Amelia's little GuestBook</h1>

<div class="post-container">
    @foreach($posts as $post)
        @include('content.post', $post)
    @endforeach
</div>
