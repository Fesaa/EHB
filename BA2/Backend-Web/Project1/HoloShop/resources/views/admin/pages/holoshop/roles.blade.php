@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/holoshop/roles.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">

@section('dashboard-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <table class="dashboard-table">
            <tr class="dashboard-table-header">
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Privileges</th>
                <th>Updated at</th>
                @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("ROLES_EDIT_PRIVILEGES")))
                    <th>Edit</th>
                @endif
            </tr>
            @foreach($roles as $role)
                <tr>
                    <th>{{ $role->id }}</th>
                    <th>{{ $role->name }}</th>
                    <th style="color: {{ $role->getColour() }}">{{ $role->getTitle() }}</th>
                    @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("ROLES_EDIT_DESC")))
                        <th class="flex-row" style="justify-content: center">
                            <form class="flex-row"
                                  action="{{ route('admin.holoshop.roles.update.desc', $role->id) }}" method="POST">
                                @csrf
                                <input type="number" name="id" value="{{ $role->id }}" hidden>
                                <textarea class="no-style" name="description" cols="30" rows="1">{{ $role->description }}</textarea>
                                <button class="dashboard-table-submit-change" type="submit">✔</button>
                            </form>
                        </th>
                    @else
                        <th>{{ $role->description }}</th>
                    @endif
                    <!--TODO: Make ADMIN_CHANGE_PRIVILEGES able to change privileges of a role -->
                    <th><select class="privileges-select">
                            @foreach($role->filter($privileges) as $privilege)
                                <option class="option_{{$role->id}}" value="{{ $privilege->value }}">{{ $privilege->name() }}</option>
                            @endforeach
                        </select></th>
                    <th>{{ $role->updated_at->format("d/m/o") }}</th>
                    @if(auth()->user()->hasPrivilege(\App\Models\Privilege::getPrivilegeValue("ROLES_EDIT_PRIVILEGES")))
                        <th><button onclick="editRole({{$role->id}})">🔵</button></th>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection

<div id="form-popup" class="flex-column">
    <div id="form-popup-2" class="flex-row" style="justify-content: center">
        <form class="styled-form" id="update-role-privileges" method="post" action="{{ route('admin.holoshop.roles.update.privileges') }}">
            @csrf
            <h3>Check any privileges you want the role to have</h3>
            <input id="role-id-input" name="id" type="number" value="0" hidden>
            <div class="flex-column">
                @foreach(\App\Models\Privilege::all() as $privilege)
                    <label>
                        <input type="checkbox" name="{{ $privilege->name }}" value="{{ $privilege->value }}">
                        {{ $privilege->name() }}
                    </label>
                @endforeach
            </div>
            <br>
            <input type="button" value="Close" class="styled-form-confirm" onclick="closeForm()">
            <input type="submit" value="Save" class="styled-form-confirm">
        </form>
    </div>
</div>

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

    function editRole(id) {
        let form = document.getElementById("update-role-privileges");

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
        document.getElementById('role-id-input').value = id;
        let popup = document.getElementById("form-popup");
        popup.style.display = "flex";
    }
</script>
