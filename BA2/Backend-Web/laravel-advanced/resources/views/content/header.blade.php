<header>
    <h1>Amelia's Little Guest Book</h1>
    <nav>
        <ul>
            <li class="nav-button"><a class="nav-link" href="/">Home</a></li>
            @guest()
            <li class="nav-button"><a class="nav-link" href="{{ route('login') }} ">Login</a></li>
            <li class="nav-button"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
            @endguest
                @auth()
                    <li class="nav-button"><a class="nav-link">Post</a></li>
                    <li class="nav-button"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    <li class="nav-button">{{ auth()->user()->name }}</li>
                @endauth
        </ul>
    </nav>
</header>
