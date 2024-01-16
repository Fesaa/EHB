@extends('admin.layouts.logs')
<link rel="stylesheet" href="{{ asset("css/admin/pages/logs/empty.css") }}">

@section('logs-content')
    <div class="float flex-column logs-welcome" >
        <h1>Welcome to the log panel</h1>
        <p>All logs you have access to are on your left</p>
        <p>This data is sensitive, don't share it</p>
        <p>If you believe you are missing permissions for something, please contact an administrator.</p>
        <br>
        <h2 style="align-self: center"> I present to you MY LOGS</h2>
        <div class="logs-meme"></div>
    </div>
@endsection
