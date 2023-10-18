@php
    /**
     * @var \App\Models\Thread[] $threads
     */
@endphp

@extends('admin.layouts.logs_table')
<link rel="stylesheet" href="{{ asset('css/shared/tables.css') }}">

@section('table-title')
    Threads logs
@endsection

@section('table-content')
    <tr class="dashboard-table-header sticky-row" style="top: 0">
        <th>User</th>
        <th>Forum</th>
        <th>Title</th>
        <th>Time (UTC)</th>
        <th>link</th>
    </tr>
    <tr>
        <th class="filter-cell"><input type="text" id="postlogs-filter-user" placeholder="Filter user"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-forum" placeholder="Filter forum"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-title" placeholder="Filter title"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-time" placeholder="Filter time"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-link" placeholder="Filter link"></th>
    </tr>
    @foreach($threads as $thread)
        <tr>
            <th>{!! $thread->owner()->colouredName() !!}</th>
            @php($forum = $thread->owningForum())
            <th><a href="{{ route('forums.show', $forum->id) }}">{{ $forum->title }}</a></th>
            <th>{!! $thread->title() !!}</th>
            <th>{{ $thread->created_at->format('h:i d/m/o') }}</th>
            <th><a href="{{ route('threads.show', $thread->id) }}">thread-{{ $thread->id }}</a></th>
        </tr>
    @endforeach
@endsection

@section('js')
    <script src="{{ asset('js/admin/pages/logs/thread.js') }}"></script>
@endsection
