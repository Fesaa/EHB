@include('partials.header')

<style>
    body {
        background: #E8D9BE;
    }

    .title {
        text-align: center;
        margin-top: 50px;
    }
</style>

<div class="content">
    <div class="title">
        <h1>Welcome to my first laravel project</h1>
    </div>

    @yield('extra-content')
</div>
