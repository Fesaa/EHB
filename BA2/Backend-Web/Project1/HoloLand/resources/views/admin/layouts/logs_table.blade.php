@extends('admin.layouts.logs')
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('logs-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <h1 style="text-align: center">@yield('table-title')</h1>
        <div style="padding: 0 2em 2em 2em">
            <div class="scrollable-table-container" >
                <table class="dashboard-table scrollable-table">
                    @yield('table-content')
                </table>
            </div>
        </div>
    </div>
    @yield('js')
@endsection
