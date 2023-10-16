<link href="{{ asset('css/partials/infobar.css') }}" rel="stylesheet">

<div class="infobar flex-column">
    <div class="float shiny-bg">
        <div class="infobar-title"><a class="clean-link" href="https://github.com/Fesaa/EHB/tree/backend-web/project1">GitHub</a>
        </div>
        <div class="infobar-content">
            <p>Follow my development!</p>
        </div>
    </div>

    @php($onlineStaff = \App\Models\Activity::staffOnlineInLast(10))
    @if(sizeof($onlineStaff) > 0)
        <div class="float shiny-bg">
            <div class="infobar-title">Online Staff</div>
            <div class="infobar-content" style="padding: 0 !important;">
                <ul class="infobar-staff-list">
                    @foreach($onlineStaff as $activity)
                        <li>@include('objects.profiles.mini_profile', ['user' => $activity->getUser()])</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="float shiny-bg">
        <div class="infobar-title">Online members</div>
        <div class="infobar-content">
            <ul class="flat-list" style="flex-wrap: wrap; font-size: smaller">
                @php($online = \App\Models\Activity::onlineInLast(10))
                @if(sizeof($online) > 0)
                    @foreach($online as $activity)
                        <li><a class="clean-link"
                               href="{{ route('profiles.show', $activity->user_id) }}">{!! $activity->name() !!}</a>
                        </li>
                    @endforeach
                @else
                    <li>...</li>
                @endif
            </ul>
        </div>
    </div>

    @php($birthdays = \App\Models\Profile::getTodaysBirthdays())
    @if(sizeof($birthdays) > 0)
        <div class="float shiny-bg">
            <div class="infobar-title">Birthdays</div>
            <div class="infobar-content">
                <ul class="flat-list" style="flex-wrap: wrap; font-size: smaller">
                    @foreach($birthdays as $profile)
                        @php($user = $profile->owningUser())
                        <li><a class="clean-link"
                               href="{{ route('profiles.show', $user->id) }}">{!! $user->colouredName() !!}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
