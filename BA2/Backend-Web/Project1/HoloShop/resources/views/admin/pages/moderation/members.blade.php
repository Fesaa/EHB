@extends('admin.layouts.dashboard')
<link rel="stylesheet" href="{{ asset("css/admin/pages/moderation/members.css") }}">
<link rel="stylesheet" href="{{ asset("css/shared/tables.css") }}">

@section('dashboard-content')
    <div class="float full-flex flex-column" style="justify-content: center">
        <table class="dashboard-table">
            <tr class="dashboard-table-header">
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Member since</th>
                <th>Profile</th>
            </tr>
            @foreach($members as $member)
                <tr>
                    <th>{{ $member->id }}</th>
                    <th>{{ $member->name }}</th>
                    <th style="color: {{ $member->getColour() }}">{{ $member->getProfile()->title }}</th>
                    <th>{{ $member->created_at->format('d/m/o') }}</th>
                    <th style="text-align: center"><a class="dashboard-table-btn" href="{{ route('admin.members.edit', $member->id) }}">🔵</a></th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

