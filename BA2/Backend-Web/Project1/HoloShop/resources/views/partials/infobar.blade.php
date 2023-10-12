<link href="{{ asset('css/partials/infobar.css') }}" rel="stylesheet">

<div class="infobar flex-column">
    <div class="float">
        <h3>First floating info</h3>
        <p>Some text</p>
    </div>

    <div class="float">
        <h3>Online staff</h3>
        <ul>
            <li>Staff One</li>
            <li>Staff Two</li>
            <li>Staff Three</li>
        </ul>
    </div>

    <div class="float">
        <h3>Birthday's!</h3>
        <ul class="flat-list">
        @foreach(\App\Models\User::getTodaysBirthDays() as $user)
            <li><a class="clean-link" href="{{ route('profile.show', $user->id) }}">{!! $user->getColouredTitle() !!}</a></li>
        @endforeach
        </ul>
    </div>
</div>
