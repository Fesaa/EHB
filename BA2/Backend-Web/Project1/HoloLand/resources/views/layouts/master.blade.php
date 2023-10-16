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

@if($errors->any())
<div id="error-popup-container" class="flex-column" style="display: flex !important;">
    <div id="error-popup" class="flex-row" style="justify-content: center">
        <div class="errors flex-column">
            <p>@yield('errors-title')</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
            <div onclick="closePopup()" id="error-close">Close</div>
        </div>
    </div>
</div>
<script>
    let errorPopupContainer = document.getElementById("error-popup-container");
    let errorPopup = document.getElementById("error-popup");
    [errorPopupContainer, errorPopup].forEach((e) => {
        e.addEventListener('click', function (event) {
            if (event.target === e) {
                errorPopupContainer.style.display = "none";
            }
        });
    });

    function closePopup() {
        errorPopupContainer.style.display = "none";
    }

</script>
@endif

<!--@include('partials.footer')-->
