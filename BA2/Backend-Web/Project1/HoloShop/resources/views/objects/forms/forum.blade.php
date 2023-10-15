@php
use \App\Models\Forum;
    /**
     * @var Forum $forum
     */

    if ($forum == null) {
        $title = "";
        $subtitle = "";
        $description = "";
    } else {
        $title = $forum->title;
        $subtitle = $forum->subtitle;
        $description = $forum->description;
    }
@endphp

<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">
<div class="styled-form-container">
    <form class="styled-form label-left" method="post" action=" {{ route('forum.forms.edit.handle', ["id" => $id]) }}">
        @csrf

        <label for="title">Title</label><br>
        <input type="text" name="title" id="title" value="{{ $title }}"><br>

        @include('objects.forms.bbcode', ["label" => "Subtitle", "type"=> "subtitle", "value" => $subtitle])
        @include('objects.forms.bbcode', ["label" => "Description", "type"=> "description", "value" => $description])
        @include('objects.forms.asset', ["label" => "Forum image", "type"=> "image"])

        <input type="submit" value="Save" class="styled-form-confirm">
    </form>
</div>
