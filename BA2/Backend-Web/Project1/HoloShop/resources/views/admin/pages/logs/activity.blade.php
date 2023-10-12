@extends('admin.layouts.logs')
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('logs-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <h1 style="text-align: center">Login logs</h1>
        <div style="padding: 0 2em 2em 2em">
            <div class="scrollable-table-container" >
                <table class="dashboard-table scrollable-table">
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
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/pages/logs/activity.js') }}"></script>

@endsection
