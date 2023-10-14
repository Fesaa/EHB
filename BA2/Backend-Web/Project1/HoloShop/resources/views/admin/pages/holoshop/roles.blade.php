@php
    use App\Models\User;
    use App\Models\Privilege;
@endphp
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
                <th>Colour</th>
                <th>Description</th>
                <th>Privileges</th>
                <th>Updated at</th>
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("ROLES_EDIT_PRIVILEGES")))
                    <th>Edit</th>
                @endif
            </tr>
            @foreach($roles as $role)
                <tr>
                    <th>{{ $role->id }}</th>
                    <th id="{{ "role-name-" . $role->id }}">{{ $role->name }}</th>
                    <th id="{{ "role-title-" . $role->id }}"
                        style="color: {{ $role->colour() }}">{{ $role->title() }}</th>
                    <th id="{{ "role-colour-" . $role->id }}">{{ $role->colour }}</th>
                    <th id="{{ "role-description-" . $role->id }}">{{ $role->description }}</th>
                    <th><select class="privileges-select">
                            @foreach($role->filter($privileges) as $privilege)
                                <option class="option_{{$role->id}}"
                                        value="{{ $privilege->value }}">{{ $privilege->name() }}</option>
                            @endforeach
                        </select></th>
                    <th>{{ $role->updated_at->format("d/m/o") }}</th>
                    @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("ROLES_EDIT_PRIVILEGES")))
                        <th>
                            <div onclick="editRole({{$role->id}})" class="hover-cursor">✏️</div>
                        </th>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection

<div id="form-popup" class="flex-column">
    <div id="form-popup-2" class="flex-row" style="justify-content: center">
        <form class="styled-form" id="update-role-privileges" method="post"
              action="{{ route('admin.holoshop.roles.update') }}">
            @csrf
            <h3 id="role-update-title" style="text-align: center"></h3>
            <input id="role-id-input" name="id" type="number" value="0" hidden>
            @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("ROLES_EDIT_MISC")))
                <label for="title">Title</label>
                <input class="no-style" id="title" name="title" type="text" style="color: {{ $role->colour }}"
                       value="{{ $role->title() }}"><br>

                <label for="colour">Colour</label>
                <input class="no-style" id="colour" name="colour" type="text" style="color: {{ $role->colour }}"
                       value="{{ $role->colour }}"><br>

                <label for="description">Description</label>
                <textarea class="no-style" id="description" name="description" cols="30"
                          rows="2">{{ $role->description }}</textarea><br>
            @endif
            @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("ROLES_EDIT_PRIVILEGES")))
                <div class="flex-column">
                    @foreach(Privilege::all() as $privilege)
                        <label>
                            <!-- TODO: Description on hover -->
                            <input type="checkbox" name="{{ $privilege->name }}" value="{{ $privilege->value }}">
                            {{ $privilege->name() }}
                        </label>
                    @endforeach
                </div>
            @endif
            <br>
            <input type="button" value="Close" class="styled-form-confirm" onclick="closeForm()">
            <input type="submit" value="Save" class="styled-form-confirm" style="font-weight: bold">
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

    let colour = document.getElementById("colour");
    let title = document.getElementById("title");
    let description = document.getElementById("description");
    colour.addEventListener('input', function (event) {
        colour.style.color = colour.value;
        title.style.color = colour.value;
    });

    function closeForm() {
        form_popup.style.display = "none";
    }

    function editRole(id) {
        let form = document.getElementById("update-role-privileges");

        let form_name = document.getElementById("role-name-" + id);
        let form_title = document.getElementById("role-title-" + id);
        let form_colour = document.getElementById("role-colour-" + id);
        let form_description = document.getElementById("role-description-" + id);


        let colour = document.getElementById("colour");
        let title = document.getElementById("title");
        let description = document.getElementById("description");

        title.value = form_title.innerText;
        title.style.color = form_colour.innerText;
        colour.value = form_colour.innerText;
        colour.style.color = form_colour.innerText;
        description.value = form_description.innerText;

        let form_title_h3 = document.getElementById('role-update-title')
        form_title_h3.innerHTML = "Update " + form_name.innerHTML

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
