@extends('layouts.master')

@section('main-content')
    @include('pages.threads.forms.base', [
    "method" => "PUT",
    "route" => route('threads.update', $thread->id),
    "forum_id" => $thread->forum_id,
    "thread" => $thread,
    "title" => $thread->title,
    "content" => $thread->content,
])
@endsection

@section('errors-title')
    Couldn't edit thread
@endsection
