<link rel="stylesheet" href="{{ asset("css/main.css") }}">
@include('content.header')

<div class="form-container">
    <form action="{{ route('new-post') }}" method="post" class="form">
        @csrf

        <label for="title">Title</label><br>
        <input type="text" id="title" name="title"><br>

        <textarea placeholder="content" rows="8" name="content"></textarea>

        <input type="submit" value="Post" class="form-confirm">
    </form>
</div>
<div class="errors-container">
    @if($errors->any())
        <div class="errors">
            <p>Cannot make post</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
