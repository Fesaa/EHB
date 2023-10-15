@php
    use \App\Models\User;
    use \App\Models\Privilege;
@endphp
@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/pages/forums/index.css') }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">

@section('main-content')
    <ul id="forums-list">
    @if(sizeof($forums) > 0)
        @foreach($forums as $forum)
            <li>@include('objects.forums.forum_preview', ['forum' => $forum])</li>
        @endforeach
    @else
        <h1>There are no forums!</h1>
    @endif
        @auth()
            @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("FORUM_CREATE")))
                <li>
                    <div class="flex-row" style="justify-content: center">
                        <button id="forum-dropdown-btn" class="form-btn dropdown-button">Create new forum</button>
                    </div>
                    <div id="forum-dropdown-content" class="hidden dropdown-content">
                        @include('objects.forms.forum', ["forum" => null, "id" => $forum->id + 1])
                    </div>
                </li>
            @endif
        @endauth
    </ul>

    <script>
        const button = document.getElementById('forum-dropdown-btn');
        const dropdownContent = document.getElementById('forum-dropdown-content');

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

@endsection

@section('errors-title')
    Couldn't update forum
@endsection
