@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset("css/pages/profile_edit.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">


@section('form')
    <div class="styled-form-container">
        <form class="styled-form label-left" method="post" action="{{ route('account.security.update', ["user" => $user]) }}" enctype="multipart/form-data" >
            @csrf

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}"><br>

            <label for="old-password">Old password</label>
            <input type="password" name="old-password" id="old-password"><br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password"><br>

            <label for="password-confirm">Confirm password</label>
            <input type="password" name="password-confirm" id="password-confirm"><br>

            <input type="submit" value="Save" class="styled-form-confirm">
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
