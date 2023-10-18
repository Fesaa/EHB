@extends('layouts.master')

@section('main-content')
        <div class="floating-thread-row">
            <h1 class="float" style="padding: 0.5em">Newest Threads</h1>
            @foreach($threads as $thread)
                @include('objects.forums.thread_float', ['thread' => $thread])
            @endforeach
            <h1 class="float" style="padding: 0.5em">Newest Profile Posts</h1>
            @foreach($posts as $post)
                @include('objects.profiles.profile_post', ["post" => $post, "postBox" => false, 'recipient' => true])
            @endforeach
        </div>

@endsection
