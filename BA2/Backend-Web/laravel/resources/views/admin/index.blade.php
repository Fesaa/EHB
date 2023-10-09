@extends('layouts.admin')

<style>

    .center  {
        text-align: center;
        margin-left: 20px;
        margin-right: 20px;
    }

    ul {
        list-style-type: none;
        margin-left: 200px;
        margin-right: 200px;
        padding: 0;
        overflow: hidden;
        text-align: center;
        display: flex;
        justify-content: space-around;
    }

    a {
        text-decoration: none;
    }

</style>


@section('content')
    <div class="center">
        <h3>Welcome to the admin panel</h3>
        <p>Welcome to the heart of our operations! The Admin Panel is your gateway to managing and overseeing the inner workings of our system. Here, you have the power to streamline processes, access critical data, and make informed decisions that drive our organization forward.</p>
        <p>Use the navigation bar to access to different admin options</p>
    </div>
    <br>
    @if(Session::get("id") != null)
        <div class="center">
            <h2>New info for Search with ID: {{Session::get("id")}}</h2>
            <h3>{{Session::get("name")}}</h3>
            <p>{{Session::get("description")}}</p>
        </div>
    @endif
    <br>
    <div class="center">
        <h3>{{ $search["name"] }}</h3>
        <p>{{ $search["description"] }}</p>
    </div>

    <ul>
    <li><a href="{{ route("admin-edit", ["id" => $id]) }}">edit</a></li>
        <li><a href="{{ route("admin-create") }}">create</a></li>
    </ul>


@endsection
