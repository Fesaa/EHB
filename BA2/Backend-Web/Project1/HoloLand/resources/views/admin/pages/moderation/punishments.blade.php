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
                <th>Status</th>
                <th>Ban</th>
                <th>UnBan</th>
            </tr>
            @foreach($members as $member)
                @php($member->populateFields())
                <tr>
                    <th>{{ $member->id }}</th>
                    <th id="{{ "member-name-" . $member->id }}">{{ $member->name }}</th>
                    @if($member->banned())
                        <th style="background: red">Banned</th>
                    @else
                        <th style="background: green">Not banned</th>
                    @endif
                    <th>
                        <form action="{{ route('admin.punishments.ban') }}" method="POST">
                            @csrf
                            <input type="number" name="id" value="{{ $member->id }}" hidden="">
                            <button class="dashboard-table-submit-change" type="submit">🔨</button>
                        </form>
                    </th>
                    <th>
                        <form action="{{ route('admin.punishments.unban') }}" method="POST">
                            @csrf
                            <input type="number" name="id" value="{{ $member->id }}" hidden="">
                            <button class="dashboard-table-submit-change" type="submit">🥺</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
