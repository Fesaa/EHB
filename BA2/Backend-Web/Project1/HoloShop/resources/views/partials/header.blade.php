
<link rel="stylesheet" href="{{ asset('css/partials/header.css') }}">

<header class="float">
    <h1 class="name">
        HoloShop
    </h1>

    <ul>
        @auth()
            <li class="nav-button secondary-button"><a>Post</a></li>
            <li class="nav-button secondary-button"><a href="{{ route('logout') }}">Logout</a></li>
            @if(auth()->user()->isStaff())
                <li class="nav-button secondary-button">Admin Dashboard</li>
            @endif
            <li class="nav-button no-hover secondary-button">{{ auth()->user()->name }}</li>
        @endauth
        @guest()
            <li class="nav-button secondary-button"><a href="{{ route('login') }}">Login</a></li>
            <li class="nav-button secondary-button"><a href="{{ route('register') }}">Register</a></li>
        @endguest
    </ul>
</header>
