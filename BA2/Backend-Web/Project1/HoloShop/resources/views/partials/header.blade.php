@php
    use App\Models\User;
@endphp
<link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">

<header class="float shiny-float">
    <h1 class="name">
        <a class="rainbow-text" href="{{ route('home') }}">HoloShop</a>
    </h1>

    <ul>
        @auth()
            <li class="nav-button secondary-button"><a>Post</a></li>
            <li class="nav-button secondary-button"><a href="{{ route('logout') }}">Logout</a></li>
            <li class="nav-button no-hover secondary-button"><a href="{{ route('account') }}">{{ User::AuthUser()->name }}</a> </li>
        @endauth
        @guest()
            <li class="nav-button secondary-button"><a href="{{ route('login') }}">Login</a></li>
            <li class="nav-button secondary-button"><a href="{{ route('register') }}">Register</a></li>
        @endguest
    </ul>
</header>
