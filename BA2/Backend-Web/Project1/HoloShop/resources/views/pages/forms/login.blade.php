@extends('layouts.master')

<link rel="stylesheet" href="{{ asset("css/pages/auth.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">

@section('main-content')
    <div class="styled-form-container">
        <form action="{{ route('login') }}" method="post" class="styled-form" >
            @csrf

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email"><br>

            <label for="password">Password</label><br>
            <input type="password" id="password" name="password"><br>

            <p>Don't have an account? <a href="{{ route('register') }}">Register</a> instead</p>

            <input type="submit" value="Login" class="styled-form-confirm">
        </form>
    </div>
@endsection

@section('errors-title')
    Failed to login
@endsection
