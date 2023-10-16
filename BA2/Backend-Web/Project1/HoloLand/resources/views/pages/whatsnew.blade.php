@extends('layouts.master')

@section('main-content')
    <div class="flex-column floating-thread-row">
        @foreach($threads as $thread)
            @include('objects.forums.thread_float', ['thread' => $thread])
        @endforeach
    </div>
@endsection
