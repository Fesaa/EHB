@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/forum_page.css') }}">

@section('main-content')
    <div id="forum-holder" class="flex-column">
        <div id="forum-info" class="float flex-row">
            <img src="{{ $forum->image() }}"  alt="forums-image">
            <div class="flex-row full-flex">
                <div id="forum-info-holder" class="flex-column">
                    <div id="forum-title">
                        {{ $forum->title }}
                    </div>
                    <div id="forum-description">
                        {{ $forum->description }}
                    </div>
                </div>
            </div>
        </div>
        <div id="forum-threads" class="float">
            <h1>Placeholder for threads to come</h1>
        </div>
    </div>
@endsection
