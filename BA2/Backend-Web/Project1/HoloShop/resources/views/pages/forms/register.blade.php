@extends('layouts.master')

<link rel="stylesheet" href="{{ asset("css/pages/auth.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">

@section('main-content')
    <div class="styled-form-container">
        <form action="{{ route('register') }}" method="post" class="styled-form" >
            @csrf

            <label for="name">Name:</label><br>
            <input type="text" id="name" name="user"><br>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email"><br>

            <label for="password">Password</label><br>
            <input type="password" id="password" name="password"><br>

            <p>Alread have an account? <a href="{{ route('login') }}">Login</a> instead</p>

            <input type="submit" value="Register" class="styled-form-confirm">
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
