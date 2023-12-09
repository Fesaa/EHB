@extends('layouts.master')

@section('main-content')
    @include('pages.posts.forms.base', [
    "method" => "PUT",
    "route" => route('posts.update', $post->id),
    "thread_id" => $post->thread_id,
    "content" => $post->content,
])
@endsection

@section('errors-title')
    Couldn't edit post
@endsection
