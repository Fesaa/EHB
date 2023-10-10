@extends('layouts.master')

<link rel="stylesheet" href="{{ asset("css/pages/auth.css") }}">

@section('main-content')
    <div class="auth-container">
        <form action="{{ route('login') }}" method="post" class="auth-form" >
            @csrf

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email"><br>

            <label for="password">Password</label><br>
            <input type="password" id="password" name="password"><br>

            <p>Don't have an account? <a href="{{ route('register') }}">Register</a> instead</p>

            <input type="submit" value="Login" class="auth-confirm">
        </form>
    </div>
    <div class="errors-container">
        @if($errors->any())
            <div class="errors">
                <p>Cannot login</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
