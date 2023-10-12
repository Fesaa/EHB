<link href="{{ asset('css/partials/infobar.css') }}" rel="stylesheet">

<div class="infobar flex-column">
    <div class="float">
        <div class="infobar-title"><a class="clean-link" href="https://github.com/Fesaa/EHB/tree/backend-web/project1">GitHub</a></div>
        <div class="infobar-content">
            <p>Follow my development!</p>
        </div>
    </div>

    <div class="float">
        <div class="infobar-title">Online Staff</div>
        <div class="infobar-content" style="padding: 0 !important;">
            <ul class="infobar-staff-list" >
                @foreach(\App\Models\Activity::staffOnlineInLast(10) as $activity)
                    <li>@include('objects.mini_profile', ['user' => $activity->user()->first()])</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="float">
        <div class="infobar-title">Online members</div>
        <div class="infobar-content">
            <ul class="flat-list">
                @foreach(\App\Models\Activity::onlineInLast(10) as $activity)
                    <li><a class="clean-link" href="{{ route('profile.show', $activity->user_id) }}">{!! $activity->getName() !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="float">
        <div class="infobar-title">Birthdays</div>
        <div class="infobar-content">
            <ul class="flat-list">
                @foreach(\App\Http\Controllers\UserController::getTodaysBirthDays() as $user)
                    <li><a class="clean-link" href="{{ route('profile.show', $user->id) }}">{!! $user->getColouredName() !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
