@php
    /**
     * @var \App\Models\Forum[] $forums
     */
@endphp

@extends('admin.layouts.logs_table')
<link rel="stylesheet" href="{{ asset('css/shared/tables.css') }}">

@section('table-title')
    Forums logs
@endsection

@section('table-content')
    <tr class="dashboard-table-header sticky-row" style="top: 0">
        <th>Title</th>
        <th>Time (UTC)</th>
        <th>link</th>
    </tr>
    <tr>
        <th class="filter-cell"><input type="text" id="postlogs-filter-title" placeholder="Filter title"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-time" placeholder="Filter time"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-link" placeholder="Filter link"></th>
    </tr>
    @foreach($forums as $forum)
        <tr>
            <th>{!! $forum->title !!}</th>
            <th>{{ $forum->created_at->format('h:i d/m/o') }}</th>
            <th><a href="{{ route('forums.show', $forum->id) }}">forum-{{ $forum->id }}</a></th>
        </tr>
    @endforeach
@endsection

@section('js')
    <script src="{{ asset('js/admin/pages/logs/forums.js') }}"></script>
@endsection
