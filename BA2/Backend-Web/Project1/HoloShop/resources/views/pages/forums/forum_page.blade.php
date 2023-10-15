@php
use App\Models\Thread;
use App\Models\User;
use App\Helper\Formatter;
@endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/forum_page.css') }}">

@section('main-content')
    <div id="forum-holder" class="flex-column">
        <div id="forum-info" class="float flex-row">
            <img src="{{ $forum->image() }}"  alt="forums-image">
            <div class="flex-column full-flex">
                <div class="flex-row info-row">
                    <div class="creation-date"> {{ Formatter::date($forum->created_at) }} </div>
                    @if($forum->canEdit(User::AuthUser()))
                        <a href="{{ route('forum.forms.edit', ["id" => $forum->id]) }}" class="clean-link">✏️</a>
                    @endif
                </div>
                <div id="forum-info-holder" class="flex-column">
                    <div id="forum-title">
                        {{ $forum->title }}
                    </div>
                    <div id="forum-description">
                        {!! $forum->description() !!}
                    </div>
                </div>
            </div>
        </div>
        <div id="forum-threads" class="flex-column">
            @php
            $threads = Thread::getVisibleThreads(User::AuthUser(), $forum->id)
            @endphp

            @if(sizeof($threads) > 0)
                @foreach($threads as $thread)
                    @include('objects.forums.thread_preview', ["thread" => $thread])
                @endforeach
            @else
                <p> No threads to show </p>
            @endif
        </div>
    </div>
@endsection
