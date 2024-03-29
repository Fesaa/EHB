@php
    use App\Models\User;
    use App\Models\Privilege;
@endphp
@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/hololand/privileges.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('dashboard-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <table class="dashboard-table">
            <tr class="dashboard-table-header">
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Updated at</th>
            </tr>
            @foreach($privileges as $privilege)
                <tr>
                    <th>{{ $privilege->id }}</th>
                    <th>{{ $privilege->name() }}</th>
                    @if(User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf("PRIVILEGES_EDIT")))
                        <th class="flex-row" style="justify-content: center">
                            <form class="flex-row"
                                  action="{{ route('admin.hololand.privileges.update') }}" method="POST">
                                @csrf
                                <input type="number" name="id" value="{{ $privilege->id }}" hidden>
                                <textarea name="description" cols="50" rows="1">{{ $privilege->description }}</textarea>
                                <button class="dashboard-table-submit-change" type="submit">✔</button>
                            </form>
                        </th>
                    @else
                        <th>{{ $privilege->description }}</th>
                    @endif
                    <th>{{ $privilege->updated_at->format("d/m/o") }}</th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
