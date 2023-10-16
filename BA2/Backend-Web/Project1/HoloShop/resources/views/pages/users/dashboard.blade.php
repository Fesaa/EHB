@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset('css/pages/account/dashboard.css') }}">

@section('form')
    <div class="float account-welcome flex-column">
        <h1>Welcome to your account panel</h1>
        <p>All your options are displayed to your left. </p>
        <p>Be careful as changing some may have lasting impact!</p>
        <p>If you believe you are missing permissions for something, please contact an administrator.</p>
        <br>
        <div class="dashboard-meme"></div>
    </div>
@endsection
