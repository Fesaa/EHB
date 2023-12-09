@extends('layouts.master')

@section('main-content')
    @include('pages.posts.forms.base', [
    "method" => "PUT",
    "route" => route('posts.store'),
    "thread_id" => $thread_id,
    "content" => "",
])
@endsection

@section('errors-title')
    Couldn't create post
@endsection
