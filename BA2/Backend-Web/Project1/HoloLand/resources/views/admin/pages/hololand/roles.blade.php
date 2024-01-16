@php
    use App\Models\User;
    use App\Models\Privilege;
@endphp
@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/hololand/roles.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">

@section('dashboard-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <table class="dashboard-table">
            <tr class="dashboard-table-header">
                <th>ID</th>
                <th>Weight</th>
                <th>Name</th>
                <th>Title</th>
                <th>Colour</th>
                <th>Description</th>
                <th>Privileges</th>
                <th>Updated at</th>
                @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("ROLES_EDIT")))
                    <th>Edit</th>
                    <th>Delete</th>
                @endif
            </tr>
            @foreach($roles as $role)
                <tr>
                    <th>{{ $role->id }}</th>
                    <th id="{{ "role-weight-" . $role->id }}">{{ $role->weight }}</th>
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
                    @if(User::AuthUser()->hasPrivilegeByString("ROLES_EDIT"))
                        <th>
                            <div onclick="editRole({{$role->id}})" class="hover-cursor">✏️</div>
                        </th>
                        <th>
                            <div onclick="deleteRole({{$role->id}})" class="hover-cursor">🗑️</div>
                        </th>
                    @endif
                </tr>
            @endforeach
            @if(User::AuthUser()->hasPrivilegeByString("ROLES_EDIT"))
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <div onclick="newRole()" class="hover-cursor">➕</div>
                    </th>
                </tr>
            @endif
        </table>
    </div>

    @if(User::AuthUser()->hasPrivilegeByString("ROLES_EDIT"))

        <div class="flex-row" style="justify-content: center">
            <div class="flex-row" style="justify-content: center; display: none; max-width: 85%; margin-top: 2em;"
                 id="delete-form-holder">
                <form class="styled-form flex-column" id="delete-role" method="post"
                      action="{{ route('admin.roles.destroy', 0) }}">
                    @csrf
                    @method('DELETE')
                    <input id="role-id-input-delete" name="role_id" type="number" value="0" hidden>

                    <label>Are you sure you want to delete this role</label>
                    <div class="flex-row" style="justify-content: center;">
                        <input type="button" value="Cancel" class="styled-form-confirm styled-input" onclick="closeDeleteForm()">
                        <input type="submit" value="Yes" class="styled-form-confirm styled-input" style="font-weight: bold">
                    </div>
                </form>
            </div>
        </div>


        <div class="flex-row" style="justify-content: center">
            <div class="flex-row" style="justify-content: center; display: none; max-width: 85%; margin-top: 2em;"
                 id="form-holder">
                <form class="styled-form" id="update-role-privileges" method="post"
                      action="{{ route('admin.roles.update', 0) }}">
                    @csrf
                    @method('PUT')

                    <h3 id="role-update-title" style="text-align: center"></h3>
                    <input id="role-id-input-update" name="role_id" type="number" value="0" hidden>

                    <div class="flex-row" style="flex-wrap: wrap; justify-content: space-between; margin-bottom: 1em">
                        <label class="styled-label" for="title">Title</label>
                        <input class="styled-input" id="title" name="title" type="text"
                               style="color: {{ $role->colour }}"
                               value="{{ $role->title() }}"><br>

                        <label class="styled-label" for="colour">Colour</label>
                        <input class="styled-input" id="colour" name="colour" type="text"
                               style="color: {{ $role->colour }}"
                               value="{{ $role->colour }}"><br>

                        <label class="styled-label" for="description">Description</label>
                        <textarea class="styled-textarea" id="description" name="description" cols="30"
                                  rows="2">{{ $role->description }}</textarea><br>
                    </div>
                    <label class="styled-label" for="weight">Weight</label>
                    <input class="styled-input" id="weight" name="weight" type="number"
                           value="{{ $role->weight }}"><br>

                    <div class="flex-row" style="flex-wrap: wrap;">
                        @foreach(Privilege::all() as $privilege)
                            <label style="flex: 20%">
                                <!-- TODO: Description on hover -->
                                <input type="checkbox" name="{{ $privilege->name }}" value="{{ $privilege->value }}">
                                {{ $privilege->name() }}
                            </label>
                        @endforeach
                    </div>

                    <br>
                    <input type="button" value="Close" class="styled-form-confirm" onclick="closeForm()">
                    <input type="submit" value="Save" class="styled-form-confirm" style="font-weight: bold">
                </form>
            </div>
        </div>

        <div class="flex-row" style="justify-content: center">
            <div class="flex-row" style="justify-content: center; display: none; max-width: 85%; margin-top: 2em;"
                 id="new-form-holder">
                <form class="styled-form" id="new-role-privileges" method="post"
                      action="{{ route('admin.roles.store') }}">
                    @csrf

                    <h3 id="new-role-title" style="text-align: center">New Role</h3>
                    <div class="flex-row" style="flex-wrap: wrap; justify-content: space-between; margin-bottom: 1em">
                        <div style="flex: 40%; display: flex;">
                            <label class="styled-label" for="key" style="width: 6em">Key</label>
                            <input class="styled-input" id="key" name="name" type="text" value=""><br>
                        </div>

                        <div style="flex: 40%; display: flex;">
                            <label class="styled-label" for="new-title" style="width: 6em">Title</label>
                            <input class="styled-input" id="new-title" name="title" type="text"
                                   style="color: rgb(128,128,128)"
                                   value=""><br>
                        </div>

                        <div style="flex: 40%; display: flex;">
                            <label class="styled-label" for="new-colour" style="width: 6em">Colour</label>
                            <input class="styled-input" id="new-colour" name="colour" type="text"
                                   style="color: rgb(128,128,128)"
                                   value="gray"><br>
                        </div>

                        <div style="flex: 40%; display: flex;">
                            <label class="styled-label" for="new-description" style="width: 6em">Description</label>
                            <input class="styled-input" id="new-description" name="description" type="text"
                                   value=""><br>
                        </div>
                    </div>

                    <label class="styled-label" for="weight">Weight</label>
                    <input class="styled-input" id="weight" name="weight" type="number"
                           value="{{ $role->weight }}"><br>

                    <div class="flex-row" style="flex-wrap: wrap;">
                        @foreach(Privilege::all() as $privilege)
                            <label style="flex: 20%">
                                <!-- TODO: Description on hover -->
                                <input type="checkbox" name="{{ $privilege->name }}" value="{{ $privilege->value }}">
                                {{ $privilege->name() }}
                            </label>
                        @endforeach
                    </div>
                    <br>
                    <input type="button" value="Close" class="styled-form-confirm" onclick="closeNewForm()">
                    <input type="submit" value="Save" class="styled-form-confirm" style="font-weight: bold">
                </form>
            </div>
        </div>

        <script src="{{ asset('js/admin/pages/hololand/roles.js') }}"></script>
    @endif
@endsection
