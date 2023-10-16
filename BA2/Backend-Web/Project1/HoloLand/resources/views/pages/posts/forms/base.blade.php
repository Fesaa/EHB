<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">

<div class="styled-form-container">
    <form class="styled-form label-left"
          method="post"
          action="{{ $route }}">
        @csrf
        @method($method)

        <input type="number" name="thread_id" value="{{ $thread_id }}" hidden>

        @include('objects.forms.bbcode', ["label" => "Content", "type"=> "content", "value" => $content])

        <input type="submit" value="Save" class="styled-form-confirm">
    </form>
</div>

