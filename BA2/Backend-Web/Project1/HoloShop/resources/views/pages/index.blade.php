<link href="{{ asset('css/pages/index.css') }}" rel="stylesheet">
@php
/** @var \App\Models\Thread $thread */
@endphp

@extends('layouts.master')

@section('main-content')
    <div class="flex-row featured-thread-row">
        @foreach($featuredThreads as $thread)
            <div style="flex: 0 0 calc(50% - 1rem);">
                <div class="featured-thread flex-column"
                     style="flex: 1 !important; background-image: url({{ $thread->bannerImage() }})">
                    <div class="featured-thread-title"><a href="{{ route("threads.show", $thread->id) }}">{{ $thread->title }}</a></div>
                    <div class="featured-thread-subtitle"> <a class="front-link" href="{{ route('profiles.show', $thread->owner()->profile()->id) }}">{{ $thread->owner()->name }}</a> {{ \App\Helper\Formatter::date($thread->created_at) }} </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex-column floating-thread-row">
        @foreach($newsThreads as $thread)
            @include('objects.forums.thread_float', ['thread' => $thread])
        @endforeach
    </div>
@endsection
