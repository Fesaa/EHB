@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/index.css") }}">

@section('dashboard-content')
    <div class="float staff-welcome flex-column">
        <h1>Welcome to the staff panel</h1>
        <p>All your options are displayed to your left. </p>
        <p>Be careful as changing some may have lasting impact!</p>
        <p>If you believe you are missing permissions for something, please contact an administrator.</p>
        <br>
        <div class="dashboard-meme"></div>
    </div>
@endsection
