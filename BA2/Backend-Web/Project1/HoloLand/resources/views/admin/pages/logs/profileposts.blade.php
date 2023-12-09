@php
    /**
     * @var \App\Models\ProfilePost[] $posts
     */
@endphp

@extends('admin.layouts.logs_table')
<link rel="stylesheet" href="{{ asset('css/shared/tables.css') }}">

@section('table-title')
    Profile Post logs
@endsection

@section('table-content')
    <tr class="dashboard-table-header sticky-row" style="top: 0">
        <th>User</th>
        <th>Profile</th>
        <th>Time (UTC)</th>
        <th>link</th>
    </tr>
    <tr>
        <th class="filter-cell"><input type="text" id="postlogs-filter-user" placeholder="Filter user"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-profile" placeholder="Filter profile"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-time" placeholder="Filter time"></th>
        <th class="filter-cell"><input type="text" id="postlogs-filter-link" placeholder="Filter link"></th>
    </tr>
    @foreach($posts as $post)
        <tr>
            <th>{!! $post->owner()->colouredName() !!}</th>
            @php($profile = $post->owningProfile())
            <th><a href="{{ route('profiles.show', $profile->id) }}">{!! $profile->owningUser()->colouredName() !!}</a></th>
            <th>{{ $post->created_at->format('h:i d/m/o') }}</th>
            <th><a href="{{ route('profiles.show', $profile->id) }}#profile-post-{{ $post->id }}">post-{{ $post->id }}</a></th>
        </tr>
    @endforeach
@endsection

@section('js')
    <script src="{{ asset('js/admin/pages/logs/posts/profile.js') }}"></script>
@endsection
