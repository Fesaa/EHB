@include('partials.admin-header')
@include("partials.errors")

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<h1 class="title">Edit search with id {{ $id }}</h1>

<form method="post" class="center" style="margin-top: 25px" action="{{ route("admin-update", ["id" => $id]) }}">
    @csrf

    <label for="name">Title:</label><br>
    <textarea id="name" name="name" rows="2" cols="50">{{ $info["name"] }}</textarea><br>

    <label for="description">Description</label><br>
    <textarea id="description" name="description" rows="8" cols="50">{{ $info["description"] }}</textarea><br><br>

    <input type="submit" id="submit" name="Save" value="Save">

</form>
@yield("errors")
