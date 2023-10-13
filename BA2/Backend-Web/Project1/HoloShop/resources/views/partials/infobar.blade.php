<link href="{{ asset('css/partials/infobar.css') }}" rel="stylesheet">

<div class="infobar flex-column">
    <div class="float">
        <div class="infobar-title"><a class="clean-link" href="https://github.com/Fesaa/EHB/tree/backend-web/project1">GitHub</a></div>
        <div class="infobar-content">
            <p>Follow my development!</p>
        </div>
    </div>

    @php($onlineStaff = \App\Models\Activity::staffOnlineInLast(10))
    @if(sizeof($onlineStaff) > 0)
        <div class="float">
            <div class="infobar-title">Online Staff</div>
            <div class="infobar-content" style="padding: 0 !important;">
                <ul class="infobar-staff-list" >
                    @foreach($onlineStaff as $activity)
                        <li>@include('objects.mini_profile', ['user' => $activity->user()->first()])</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="float">
        <div class="infobar-title">Online members</div>
        <div class="infobar-content">
            <ul class="flat-list">
                @php($online = \App\Models\Activity::onlineInLast(10))
                @if(sizeof($online) > 0)
                    @foreach($online as $activity)
                        <li><a class="clean-link" href="{{ route('profile.show', $activity->user_id) }}">{!! $activity->getName() !!}</a></li>
                    @endforeach
                @else
                    <li>...</li>
                @endif
            </ul>
        </div>
    </div>

    @php($birthdays = \App\Http\Controllers\UserController::getTodaysBirthDays())
    @if(sizeof($birthdays) > 0)
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
    @endif
</div>
