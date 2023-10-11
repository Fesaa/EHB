@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset("css/pages/profile_edit.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">


@section('form')
    <div class="styled-form-container">
        <form class="styled-form label-left" method="post" action="{{ route('account.profile.update') }}" enctype="multipart/form-data" >
            @csrf

            <label for="name">Username</label><br>
            <input type="text" name="name" id="name" value="{{ $user->name }}"><br>

            <label for="pronouns">Pronouns</label><br>
            <input type="text" name="pronouns" id="pronouns" value="{{ $profile->pronouns }}"><br>

            <label for="birthday">Birthday</label><br>
            <input type="date" name="birthday" id="birthday" value="{{ $profile->birthday->format('o-m-d') }}"><br>

            <label for="aboutme">About me</label><br>
            <textarea id="aboutme" name="aboutme" cols="50" rows="10">{{ $profile->bio }}</textarea><br>

            <label>Profile Picture</label><br>
            <div class="flex-row">
                <input type="radio" name="pfp-type" value="URL" id="pfp-upload-radio-url" checked>
                <label for="pfp-upload-radio-url">URL</label>
                <input type="radio" name="pfp-type" value="FILE" id="pfp-upload-radio-file">
                <label for="pfp-upload-radio-file">File</label><br>
            </div><br>

            <input type="text" name="pfp-url" id="pfp-upload-url">
            <input type="file" name="pfp-file" id="pfp-upload-file" style="display: none;"><br>

            <label>Banner Picture</label><br>
            <div class="flex-row">
                <input type="radio" name="banner-type" value="URL" id="banner-upload-radio-url" checked>
                <label for="banner-upload-radio-url">URL</label>
                <input type="radio" name="banner-type" value="FILE" id="banner-upload-radio-file">
                <label for="banner-upload-radio-file">File</label><br>
            </div><br>

            <input type="text" name="banner-url" id="banner-upload-url">
            <input type="file" name="banner-file" id="banner-upload-file" style="display: none;"><br>

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

    <script>
        const pfpUploadRadioURL = document.getElementById("pfp-upload-radio-url");
        const pfpUploadRadioFile = document.getElementById("pfp-upload-radio-file");

        pfpUploadRadioURL.addEventListener("click", function() {
            document.getElementById("pfp-upload-url").style.display = "block";
            document.getElementById("pfp-upload-file").style.display = "none";
        });
        pfpUploadRadioFile.addEventListener("click", function() {
            document.getElementById("pfp-upload-url").style.display = "none";
            document.getElementById("pfp-upload-file").style.display = "block";
        });

        const bannerUploadRadioURL = document.getElementById("banner-upload-radio-url");
        const bannerUploadRadioFile = document.getElementById("banner-upload-radio-file");

        bannerUploadRadioURL.addEventListener("click", function() {
            document.getElementById("banner-upload-url").style.display = "block";
            document.getElementById("banner-upload-file").style.display = "none";
        });
        bannerUploadRadioFile.addEventListener("click", function() {
            document.getElementById("banner-upload-url").style.display = "none";
            document.getElementById("banner-upload-file").style.display = "block";
        });
    </script>


@endsection

