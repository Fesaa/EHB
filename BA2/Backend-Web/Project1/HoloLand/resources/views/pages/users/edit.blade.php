@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset("css/pages/profile_edit.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">


@section('form')
    <div class="styled-form-container">
        <form class="styled-form label-left" method="post" action="{{ route('users.update', ["user" => $user->id]) }}" enctype="multipart/form-data" >
            @csrf
            @method('PUT')

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
@endsection

@section('errors-title')
    Can't update your account; please check your input
@endsection
