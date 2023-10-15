@extends('layouts.master')

@section('main-content')
    @include('pages.forums.forms.base', [
    "method" => "POST",
    "route" => route('forums.store'),
    "forum" => null,
    "title" => "",
    "subtitle" => "",
    "description" => "",
])
@endsection

@section('errors-title')
    Couldn't create forum
@endsection
