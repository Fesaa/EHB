@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/thread_page.css') }}">

@section('main-content')
    <div id="thread-holder" class="flex-column float shiny-bg">
        <div id="thread-main" class="flex-row">
            <div id="thread-owner">
                @include('objects.profiles.small_profile', ["member" => $thread->owner(), "profile" => $thread->owner()->profile()])
            </div>
            <div id="thread-content">
                <div id="thread-title">
                    <h1>{!!  $thread->title() !!}</h1>
                </div>
                <div id="thread-description">
                    {!! $thread->content() !!}
                </div>
            </div>
        </div>
        <div id="thread-posts">
        </div>
    </div>
@endsection
