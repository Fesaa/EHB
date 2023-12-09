@extends('admin.layouts.logs_table')
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('table-title')
    Activity logs
@endsection

@section('table-content')
    <tr class="dashboard-table-header sticky-row" style="top: 0">
        <th>User</th>
        <th>url</th>
        <th>time (UTC)</th>
    </tr>
    <tr class="sticky-row" style="top: 0">
        <th class="filter-cell"><input type="text" id="activitylogs-filter-user" placeholder="Filter user"></th>
        <th class="filter-cell"><input type="text" id="activitylogs-filter-url" placeholder="Filter url"></th>
        <th class="filter-cell"><input type="text" id="activitylogs-filter-time" placeholder="Filter time"></th>
    </tr>
    @foreach($activities as $activity)
        <tr>
            <th>{{ $activity->user()->first()->name }}</th>
            <th>{{ $activity->url }}</th>
            <th>{{ $activity->created_at->format('h:i d/m/o') }}</th>
        </tr>
    @endforeach

@endsection

@section('js')
    <script src="{{ asset('js/admin/pages/logs/activity.js') }}"></script>
@endsection
