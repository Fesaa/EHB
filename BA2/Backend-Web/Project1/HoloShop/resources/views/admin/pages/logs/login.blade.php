@extends('admin.layouts.logs')
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('logs-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <h1 style="text-align: center">Login logs</h1>
        <div style="padding: 0 2em 2em 2em">
            <div class="scrollable-table-container" >
                <table class="dashboard-table scrollable-table">
                    <tr class="dashboard-table-header sticky-row" style="top: 0">
                        <th>email</th>
                        <th>ip address</th>
                        <th>user agent</th>
                        <th>outcome</th>
                        <th>time (UTC)</th>
                    </tr>
                    <tr class="sticky-row" style="top: 0">
                        <th class="filter-cell"><input type="text" id="loginlogs-filter-email" placeholder="Filter email"></th>
                        <th class="filter-cell"><input type="text" id="loginlogs-filter-ip" placeholder="Filter ip"></th>
                        <th class="filter-cell"><input type="text" id="loginlogs-filter-user-agent" placeholder="Filter user agent"></th>
                        <th class="filter-cell"><input type="text" id="loginlogs-filter-outcome" placeholder="Filter outcome"></th>
                        <th class="filter-cell"><input type="text" id="loginlogs-filter-time" placeholder="Filter time"></th>
                    </tr>
                    @foreach($logs as $log)
                        <tr>
                            <th>{{ $log->email }}</th>
                            <th>{{ $log->ip_address }}</th>
                            <th>{{ $log->user_agent }}</th>
                            <th>{{ $log->success ? 'Success' : 'Fail' }}</th>
                            <th>{{ $log->created_at->format('h:i d/m/o') }}</th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/pages/logs/login.js') }}"></script>

@endsection
