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
                <h3 id="title" style="text-align: center;"> {{ $profile->title() }} </h3>
                <p id="title-tooltip" style="display: none; font-size: small;">You can't change your title</p>
            @endif

            <label for="pronouns">Pronouns</label><br>
            <input type="text" name="pronouns" id="pronouns" value="{{ $profile->pronouns }}"><br>

            <label for="birthday">Birthday</label><br>
            <input type="date" name="birthday" id="birthday" value="@if($profile->birthday != null){{ $profile->birthday->format('o-m-d') }}@endif"><br>

            <label for="location">Location</label><br>
            <input type="text" name="location" id="location" value="{{ $profile->location }}"><br>

            @include('objects.forms.bbcode', ["label" => "About me", "type"=> "aboutme", "value" => $profile->bio])
            @include('objects.forms.asset', ["label" => "Profile Picture", "type"=> "pfp"])
            @include('objects.forms.asset', ["label" => "Banner Picture", "type"=> "banner"])

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
    </script>

@endsection

@section('errors-title')
    Something went wrong! Can't edit your profile!
@endsection
