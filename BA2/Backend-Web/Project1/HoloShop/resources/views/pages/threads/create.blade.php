@extends('layouts.master')

@section('main-content')
    @include('pages.threads.forms.base', [
    "method" => "POST",
    "route" => route('threads.store'),
    "forum_id" => $forum_id,
    "thread" => null,
    "title" => "",
    "content" => "",
])
@endsection

@section('errors-title')
    Couldn't create thread
@endsection
