@extends('layouts.master')

@section('main-content')
    @include('objects.forms.forum', ["forum" => $forum, "id" => $forum->id])
@endsection

@section('errors-title')
    Couldn't update forum
@endsection
