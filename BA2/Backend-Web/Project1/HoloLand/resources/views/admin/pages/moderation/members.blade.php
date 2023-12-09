@php
    use App\Models\User;
    use App\Models\Privilege;
    use App\Models\Role;
    /**
    * @var User[] $members
    */
@endphp
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
                <th>Roles</th>
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("MEMBERS_EDIT_ROLES")))
                    <th>Edit</th>
                @endif
            </tr>
            @foreach($members as $member)
                @php($member->populateFields())
                <tr>
                    <th>{{ $member->id }}</th>
                    <th id="{{ "member-name-" . $member->id }}">{{ $member->name }}</th>
                    <th style="color: {{ $member->colour() }}">{{ $member->profile()->title() }}</th>
                    <th>{{ $member->created_at->format('d/m/o') }}</th>
                    <th><select class="roles-select">
                            @foreach($member->roles()->get() as $role)
                                <option class="option_{{$member->id}}"
                                        value="{{ $role->id }}">{{ $role->name() }}</option>
                            @endforeach
                        </select></th>
                    @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("MEMBERS_EDIT_ROLES")))
                        <th>
                            <div onclick="editMemberRoles({{$member->id}})" class="hover-cursor">✏️</div>
                        </th>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
    @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("MEMBERS_EDIT_ROLES")))
        <div id="form-holder" class="flex-row" style="display: none; justify-content: center; flex: 1; margin-top: 1em;">
            <form class="styled-form" id="update-member-roles" method="post"
                  action="{{ route('admin.members.edit.roles.update') }}">
                @csrf
                <h3 id="members-roles-update-form-title"></h3>
                <input id="member-id-input" name="id" type="number" value="0" hidden>
                <div class="flex-column">
                    @foreach(Role::all()->sortByDesc('weight') as $role)
                        <label>
                            <!-- TODO: Description on hover -->
                            <input type="checkbox" name="{{ $role->name }}" value="{{$role->id}}">
                            {{ $role->name() }}
                        </label>
                    @endforeach
                </div>
                <br>
                <input type="button" value="Close" class="styled-form-confirm" onclick="closeForm()">
                <input type="submit" value="Save" class="styled-form-confirm" style="font-weight: bold">
            </form>
        </div>
    @endif
@endsection

<script>
    function closeForm() {
        const form_holder = document.getElementById('form-holder');
        form_holder.style.display = "none";
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
        const form_holder = document.getElementById('form-holder');
        form_holder.style.display = "";
    }
</script>
