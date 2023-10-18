@extends('layouts.master')

<link rel="stylesheet" href="{{ asset("css/pages/members.css") }}">

@section('main-content')
    <div class="flex-row" style="justify-content: center">
        <h1 class="float members-title">HoloLand has {{sizeof($users)}} members!</h1>
    </div>
    <div class="member-grid">
        @foreach($users as $user)
            @include('objects.profiles.small_profile', ['member' => $user, 'profile' => $user->profile()])
        @endforeach
    </div>
@endsection
