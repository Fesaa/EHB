@php
    use App\Models\User;
    use App\Models\Privilege;
    use \Illuminate\Support\Facades\Crypt;
@endphp
@extends('layouts.account_management')
<link rel="stylesheet" href="{{ asset("css/pages/profile_edit.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">


@section('form')
    <div class="styled-form-container">
        <form class="styled-form label-left" method="post" action="{{ route('account.profile.update') }}"
              enctype="multipart/form-data">
            @csrf

            @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('MEMBERS_EDIT_PROFILE')))
                @if(User::AuthUser()->getHighestRole()->outRanks($user->getHighestRole())) @endif
                <input type="hidden" name="id" value="{{ Crypt::encrypt($user->id) }}">
            @endif

            <label for="name">Username</label><br>
            <input type="text" name="name" id="name" value="{{ $user->name }}"><br>

            <label for="title">Title:</label>
            @if($user->hasPrivilege(Privilege::privilegeValueOf('TITLE_EDIT')))
                <input type="text" name="title" id="title" value="{{ $profile->title }}"><br>
            @else
                <h3 id="title" style="text-align: center;"> {{ $profile->getTitle() }} </h3>
                <p id="title-tooltip" style="display: none; font-size: small;">You can't change your title</p>
            @endif

            <label for="pronouns">Pronouns</label><br>
            <input type="text" name="pronouns" id="pronouns" value="{{ $profile->pronouns }}"><br>

            <label for="birthday">Birthday</label><br>
            <input type="date" name="birthday" id="birthday" value="
           @if($profile->birthday != null)
            {{ $profile->birthday->format('o-m-d') }}
           @endif
            "><br>

            <label for="location">Location</label><br>
            <input type="text" name="location" id="location" value="{{ $profile->location }}"><br>

            <label for="aboutme">About me
            </label>
            <p style="font-size: small; text-align: left">
                BBCode is avaible for formatting, use square brackets with specific tags like [b] for bold text or [url] for hyperlinks. For example, [b]This is bold[/b] and [url=https://www.example.com]Visit here[/url]. If you want to quote text, use [quote]. For further details, check this <a target="_blank" href="https://en.wikipedia.org/wiki/BBCode">page</a>.
            </p>
            <textarea id="aboutme" name="aboutme" cols="100" rows="15">{{ $profile->bio }}</textarea><br>

            <label>Profile Picture</label><br>
            <div class="flex-row">
                <input type="radio" name="pfp-type" value="URL" id="pfp-upload-radio-url" checked>
                <label for="pfp-upload-radio-url">URL</label>
                <input type="radio" name="pfp-type" value="FILE" id="pfp-upload-radio-file">
                <label for="pfp-upload-radio-file">File</label><br>
            </div>
            <br>

            <input type="text" name="pfp-url" id="pfp-upload-url">
            <input type="file" name="pfp-file" id="pfp-upload-file" style="display: none;"><br>

            <label>Banner Picture</label><br>
            <div class="flex-row">
                <input type="radio" name="banner-type" value="URL" id="banner-upload-radio-url" checked>
                <label for="banner-upload-radio-url">URL</label>
                <input type="radio" name="banner-type" value="FILE" id="banner-upload-radio-file">
                <label for="banner-upload-radio-file">File</label><br>
            </div>
            <br>

            <input type="text" name="banner-url" id="banner-upload-url">
            <input type="file" name="banner-file" id="banner-upload-file" style="display: none;"><br>

            <input type="submit" value="Save" class="styled-form-confirm">
        </form>
    </div>

    <script>
        const input = document.getElementById('title');
        const tooltip = document.getElementById('title-tooltip');

        input.addEventListener('mouseover', () => {
            tooltip.style.display = 'block';
        });

        input.addEventListener('mouseout', () => {
            tooltip.style.display = 'none';
        });


        const pfpUploadRadioURL = document.getElementById("pfp-upload-radio-url");
        const pfpUploadRadioFile = document.getElementById("pfp-upload-radio-file");

        pfpUploadRadioURL.addEventListener("click", function () {
            document.getElementById("pfp-upload-url").style.display = "block";
            document.getElementById("pfp-upload-file").style.display = "none";
        });
        pfpUploadRadioFile.addEventListener("click", function () {
            document.getElementById("pfp-upload-url").style.display = "none";
            document.getElementById("pfp-upload-file").style.display = "block";
        });

        const bannerUploadRadioURL = document.getElementById("banner-upload-radio-url");
        const bannerUploadRadioFile = document.getElementById("banner-upload-radio-file");

        bannerUploadRadioURL.addEventListener("click", function () {
            document.getElementById("banner-upload-url").style.display = "block";
            document.getElementById("banner-upload-file").style.display = "none";
        });
        bannerUploadRadioFile.addEventListener("click", function () {
            document.getElementById("banner-upload-url").style.display = "none";
            document.getElementById("banner-upload-file").style.display = "block";
        });
    </script>

@endsection

@section('errors-title')
    Something went wrong! Can't edit your profile!
@endsection
