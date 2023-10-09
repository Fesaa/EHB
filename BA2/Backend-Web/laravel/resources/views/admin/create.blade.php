@include('partials.admin-header')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<h1 class="title">Make a new search</h1>

<form method="post" class="center" style="margin-top: 25px" action="{{ route("admin-update") }}">
    @csrf

    <label for="title">Title:</label><br>
    <textarea id="title" name="title" rows="2" cols="50"></textarea><br>

    <label for="description">Description</label><br>
    <textarea id="description" name="description" rows="8" cols="50"></textarea><br><br>

    <input type="submit" id="submit" name="Save" value="Save">

</form>
