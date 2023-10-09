@include('partials.admin-header')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="content">
    <div class="title">
        <h1>Welcome to the admin section of my first laravel project</h1>
    </div>

    @yield('content')
</div>
