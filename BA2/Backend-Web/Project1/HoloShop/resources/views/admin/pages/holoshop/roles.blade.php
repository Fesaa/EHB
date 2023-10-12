@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/holoshop/roles.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

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
                                <textarea name="description" cols="30" rows="1">{{ $role->description }}</textarea>
                                <button class="dashboard-table-submit-change" type="submit">✔</button>
                            </form>
                        </th>
                    @else
                        <th>{{ $role->description }}</th>
                    @endif
                    <!--TODO: Make ADMIN_CHANGE_PRIVILEGES able to change privileges of a role -->
                    <th><select class="privileges-select">
                            @foreach($role->filter($privileges) as $privilege)
                                <option value="{{ $privilege->id }}">{{ $privilege->name() }}</option>
                            @endforeach
                        </select></th>
                    <th>{{ $role->updated_at->format("d/m/o") }}</th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
