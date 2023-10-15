@extends('layouts.master')

@section('main-content')
    @include('pages.forums.forms.base', [
    "method" => "PUT",
    "route" => route('forums.update', $forum->id),
    "forum" => $forum,
    "title" => $forum->title,
    "subtitle" => $forum->subtitle,
    "description" => $forum->description,
])
@endsection

@section('errors-title')
    Couldn't create forum
@endsection
