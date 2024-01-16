@php
    use App\Models\Thread;
    use App\Models\User;
    use App\Helper\Formatter;

    /**
     * @var \App\Models\Forum $forum
     */

@endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/forum_page.css') }}">

@section('main-content')
    <p class="road-links"><a href="{{ route('forums.index') }}">Forums</a></p>
    <div id="forum-holder" class="flex-column">
        <div id="forum-info" class="float flex-row">
            <img src="{{ $forum->image() }}" alt="forums-image">
            <div class="flex-column full-flex">
                <div class="flex-row info-row">
                    <div class="creation-date"> {{ Formatter::date($forum->created_at) }} </div>
                    @if($forum->canEdit(User::AuthUser()))
                        <div class="flex-row">
                            <a href=" {{ route('forums.edit', ["forum" => $forum->id]) }} " class="clean-link">✏️</a>
                            <form action="{{ route('forums.destroy', ["forum" => $forum->id]) }}" method="post" style="margin-left: 1em">
                                @csrf
                                @method("delete")
                                <input type="submit" value="🗑️">
                            </form>
                        </div>
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
            @endif
            @if($forum->canPostOn(User::AuthUser()))

                <div class="flex-row" style="justify-content: center">
                    <button id="thread-dropdown-btn" class="form-btn dropdown-button">Create new thread</button>
                </div>

                <div id="thread-dropdown-content" class="hidden dropdown-content">
                    @include('pages.threads.forms.base', [
                            "method" => "post",
                            "route" => route('threads.store'),
                            "forum_id" => $forum->id,
                            "thread" => null,
                            "title" => "",
                            "content" => "",
                            "cloaks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_CLOAK"),
                            "locks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_LOCK"),
                            "fields" => $forum->getFormFields(),
                            ])
                </div>

                <script>
                    const button = document.getElementById('thread-dropdown-btn');
                    const dropdownContent = document.getElementById('thread-dropdown-content');

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
