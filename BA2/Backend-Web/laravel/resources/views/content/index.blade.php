<style>
    .search-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        width: 80%;
    }

    .search-container h1 {
        color: #9ca3af;
        font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
    }
</style>

@extends('layouts.master')

@section('extra-content')
    <div class="search-container">
        <h1>Searching for: </h1>
        @for($id = 1; $id <= sizeof($booksets); $id++)
        <div class="search">
            <h2> {{ $booksets[$id]["name"] }} </h2>
            <p>{{ $booksets[$id]["description"] }}</p>
            <a href="{{ route('item', ["id" => $id]) }}">details</a>
            <hr>
        </div>
        @endfor
    </div>
@endsection
