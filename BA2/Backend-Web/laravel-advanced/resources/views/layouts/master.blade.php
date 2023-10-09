
<link rel="stylesheet" href="{{ asset("css/main.css") }}">

<h1 class="center">Amelia's little GuestBook</h1>

@foreach($posts as $post)
@include('content.post', $post)
@endforeach
