@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/index.css') }}">

@section('main-content')
    @if(sizeof($forums) > 0)
        <ul id="forums-list">
            @foreach($forums as $forum)
                    <li>@include('objects.forums.forum_preview', ['forum' => $forum])</li>
            @endforeach
        </ul>
    @else
        <h1>There are no forums!</h1>
    @endif
@endsection
