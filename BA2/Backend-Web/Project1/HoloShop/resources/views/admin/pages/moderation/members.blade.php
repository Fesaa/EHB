@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/moderation/members.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">

@section('dashboard-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <table class="dashboard-table">
            <tr class="dashboard-table-header">
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Member since</th>
                <th>Profile</th>
                <th>Roles</th>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("MEMBERS_EDIT_ROLES")))
                    <th>Edit</th>
                @endif
            </tr>
            @foreach($members as $member)
                <tr>
                    <th>{{ $member->id }}</th>
                    <th id="{{ "member-name-" . $member->id }}">{{ $member->name }}</th>
                    <th style="color: {{ $member->getColour() }}">{{ $member->getProfile()->getTitle() }}</th>
                    <th>{{ $member->created_at->format('d/m/o') }}</th>
                    <th style="text-align: center"><a class="dashboard-table-btn" href="{{ route('admin.members.edit', $member->id) }}">🔵</a></th>
                    <th><select class="roles-select">
                            @foreach($member->roles()->get() as $role)
                                <option class="option_{{$member->id}}" value="{{ $role->id }}">{{ $role->name() }}</option>
                            @endforeach
                        </select></th>
                    @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("MEMBERS_EDIT_ROLES")))
                        <th><div onclick="editMemberRoles({{$member->id}})" class="hover-cursor">🔵</div></th>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("MEMBERS_EDIT_ROLES")))
    <div id="form-popup" class="flex-column">
        <div id="form-popup-2" class="flex-row" style="justify-content: center">
            <form class="styled-form" id="update-member-roles" method="post" action="{{ route('admin.members.edit.roles.update') }}">
                @csrf
                <h3 id="members-roles-update-form-title"></h3>
                <input id="member-id-input" name="id" type="number" value="0" hidden>
                <div class="flex-column">
                    @foreach(\App\Models\Role::all()->sortByDesc('weight') as $role)
                        <label>
                            <input type="checkbox" name="{{ $role->name }}" value="{{$role->id}}">
                            {{ $role->name() }}
                        </label>
                    @endforeach
                </div>
                <br>
                <input type="button" value="Close" class="styled-form-confirm" onclick="closeForm()">
                <input type="submit" value="Save" class="styled-form-confirm">
            </form>
        </div>
    </div>
@endif

<script>
    form_popup = document.getElementById("form-popup");
    form_popup_2 = document.getElementById("form-popup-2");
    [form_popup, form_popup_2].forEach(f => {
        f.addEventListener('click', function (event) {
            if (event.target === f) {
                form_popup.style.display = "none";
            }
        });
    })

    function closeForm() {
        form_popup.style.display = "none";
    }

    function editMemberRoles(id) {
        let form = document.getElementById("update-member-roles");
        let title = document.getElementById("members-roles-update-form-title")
        let name = document.getElementById("member-name-" + id);
        title.innerHTML = "Update " + name.innerText + "'s roles"

        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        const privileges = document.querySelectorAll('.option_' + id);
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
            for (let i = 0; i < privileges.length; i++) {
                if (checkbox.value === privileges[i].value) {
                    checkbox.checked = true;
                    break
                }
            }
        });
        document.getElementById('member-id-input').value = id;
        let popup = document.getElementById("form-popup");
        popup.style.display = "flex";
    }
</script>
