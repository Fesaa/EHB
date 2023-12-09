@php
    use App\Helper\Formatter;
    use \App\Models\User;
@endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/thread_page.css') }}">

@section('main-content')
    <p class="road-links"><a href="{{ route('forums.index') }}">Forums</a> -> <a href="{{ route('forums.show', $thread->owningForum()->id) }}">{{ $thread->owningForum()->title }}</a></p>
    <div id="thread-holder" class="flex-column">
        <h1 style="padding-left: 2em">{{  $thread->title }}</h1>
        <div id="thread-main" class="flex-row float shiny-bg">
            <div id="thread-owner">
                @include('objects.profiles.small_profile', ["member" => $thread->owner(), "profile" => $thread->owner()->profile()])
            </div>
            <div id="thread-content">
                <div class="flex-row info-row">
                    <div class="creation-date"> {{ Formatter::date($thread->created_at) }} </div>
                    @if($thread->canEdit(User::AuthUser()))
                        <div class="flex-row">
                            <a href=" {{ route('threads.edit', ["thread" => $thread->id]) }} " class="clean-link">✏️</a>
                            <form action="{{ route('threads.destroy', ["thread" => $thread->id]) }}" method="post" style="margin-left: 1em">
                                @csrf
                                @method("delete")
                                <input type="submit" value="🗑️">
                            </form>
                        </div>
                    @endif
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
                    <div id="thread-post-{{ $post->id }}" class="float thread-post flex-row">
                        <div class="post-owner">
                            @include('objects.profiles.small_profile', ["member" => $post->owner(), "profile" => $post->owner()->profile()])
                        </div>
                        <div class="post-content-box flex-column">
                            <div class="flex-row info-row">
                                <a class="creation-date clean-link" href="#thread-post-{{ $post->id }}"> {{ Formatter::date($post->created_at) }} </a>
                                @if($post->canEdit(User::AuthUser()))
                                    <div class="flex-row">
                                        <a href=" {{ route('posts.edit', ["post" => $post->id]) }} " class="clean-link">✏️</a>
                                        <form action="{{ route('posts.destroy', ["post" => $post->id]) }}" method="post" style="margin-left: 1em">
                                            @csrf
                                            @method("delete")
                                            <input type="submit" value="🗑️">
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="post-content">
                                {!! $post->content() !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if($thread->canPostOn(User::AuthUser()))

                <div class="flex-row" style="justify-content: center">
                    <button id="post-dropdown-btn" class="form-btn dropdown-button">Create new post</button>
                </div>

                <div id="post-dropdown-content" class="hidden dropdown-content">
                    @include('pages.posts.forms.base', [
                    "method" => "post",
                    "route" => route('posts.store'),
                    "thread_id" => $thread->id,
                    "content" => "",
                    "cloaks" => \App\Models\User::AuthUser()->hasPrivilegeByString("THREAD_CLOAK"),
                    "locks" => \App\Models\User::AuthUser()->hasPrivilegeByString("THREAD_LOCK"),
                    ])
                </div>
                <script>
                    const button = document.getElementById('post-dropdown-btn');
                    const dropdownContent = document.getElementById('post-dropdown-content');

                    // Add a click event listener to the button
                    button.addEventListener('click', () => {
                        if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
                            // Show the dropdown with a gradual animation
                            dropdownContent.style.display = 'flex';
                            setTimeout(() => {
                                dropdownContent.style.opacity = '1';
                            }, 10);
                        } else {
                            // Hide the dropdown with a gradual animation
                            dropdownContent.style.opacity = '0';
                            setTimeout(() => {
                                dropdownContent.style.display = 'none';
                            }, 300); // Adjust the duration of the animation (in milliseconds) as needed
                        }
                    });
                </script>
            @endif
        </div>
    </div>
@endsection
