<link href="{{ asset('css/shared/global.css') }}" rel="stylesheet">
<link href="{{ asset('css/layouts/master.css') }}" rel="stylesheet">

@include('partials.header')

<div class="master-formatting">

    <div class="master-formatting-sidebar">
        @include('partials.sidebar')
    </div>

    <div class="master-formatting-main-content">
        @yield('main-content')
    </div>

    <div class="master-formatting-infobar">
        @include('partials.infobar')
    </div>
</div>


<!--@include('partials.footer')-->
