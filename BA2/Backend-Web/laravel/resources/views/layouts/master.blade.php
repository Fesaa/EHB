@include('partials.header')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="content">
    <div class="title">
        <h1>Welcome to my first laravel project</h1>
    </div>

    @yield('extra-content')
    @yield('about')
</div>
