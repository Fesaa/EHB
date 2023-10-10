<link rel="stylesheet" href="{{ asset("css/main.css") }}">
<script>let checkbox</script>
@include('content.header')


<div class="post-container">
    @foreach($posts as $post)
        @include('content.post', $post)
    @endforeach
</div>
