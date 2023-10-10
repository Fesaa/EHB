<link href="{{ asset('css/partials/sidebar.css') }}" rel="stylesheet">

<div class="sidebar flex-column float" style="justify-content: space-between">
    <ul>
        <li class="primary-button"><a href="{{ route('home') }}">Home</a></li>
        <li>What's new</li>
        <li>Shop</li>
        <li>Threads</li>
        <li><a href="{{ route('members') }}">Members</a></li>
        <li class="no-hover"></li>
        <li class="no-hover"></li>
        <li class="no-hover"></li>
        @auth()
            <li><a href="{{ route('profile.show', auth()->user()->id) }}">Profile</a></li>
        @endauth
    </ul>
</div>
