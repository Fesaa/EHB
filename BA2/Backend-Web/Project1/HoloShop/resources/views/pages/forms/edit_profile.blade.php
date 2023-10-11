@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset("css/pages/profile_edit.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">


@section('form')
    <div class="styled-form-container">
        <form class="styled-form label-left" method="post" action="{{ route('account.profile.update') }}">
            @csrf

            <label for="name">Username</label><br>
            <input type="text" name="name" id="name" value="{{ $user->name }}"><br>

            <label for="pronouns">Pronouns</label><br>
            <input type="text" name="pronouns" id="pronouns" value="{{ $profile->pronouns }}"><br>

            <label for="birthday">Birthday</label><br>
            <input type="date" name="birthday" id="birthday" value="{{ $profile->birthday->format('o-m-d') }}"><br>

            <label for="aboutme">About me</label><br>
            <textarea id="aboutme" name="aboutme" cols="50" rows="10">{{ $profile->bio }}</textarea><br>


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
