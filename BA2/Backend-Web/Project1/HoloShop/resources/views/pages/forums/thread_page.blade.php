@php
    use App\Helper\Formatter;
    use \App\Models\User;
@endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/thread_page.css') }}">

@section('main-content')
    <div id="thread-holder" class="flex-column">
        <div id="thread-main" class="flex-row float shiny-bg">
            <div id="thread-owner">
                @include('objects.profiles.small_profile', ["member" => $thread->owner(), "profile" => $thread->owner()->profile()])
            </div>
            <div id="thread-content">
                <div class="flex-row info-row">
                    <div class="creation-date"> {{ Formatter::date($thread->created_at) }} </div>
                    @if($thread->canEdit(User::AuthUser()))
                        <a href="" class="clean-link">✏️</a>
                    @endif
                </div>
                <div id="thread-title">
                    <h1>{!!  $thread->title() !!}</h1>
                </div>
                <div id="thread-description">
                    {!! $thread->content() !!}
                </div>
            </div>
        </div>
        <div id="thread-posts">
            @php
            $posts = $thread->getReplies();
            @endphp

            @if(sizeof($posts) > 0)
                @foreach($posts as $post)
                    <div class="float thread-post flex-row">
                        <div class="post-owner">
                            @include('objects.profiles.small_profile', ["member" => $post->owner(), "profile" => $post->owner()->profile()])
                        </div>
                        <div class="post-content-box flex-column">
                            <div class="flex-row info-row">
                                <div class="creation-date"> {{ Formatter::date($post->created_at) }} </div>
                                @if($post->canEdit(User::AuthUser()))
                                    <a href="" class="clean-link">✏️</a>
                                @endif
                            </div>
                            <div class="post-content">
                                {!! $post->content() !!}
                            </div>
                            <div class="post-signature">
                                <!-- TODO: Add signature -->
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p> No posts to show </p>
            @endif
        </div>
    </div>
@endsection
