@extends('partials.header')

<style>
    .admin {
        display: inline;
    }
</style>

@section('admin-routes')
    <div class="admin">
        <a href="{{ route('admin-index') }}">Admin</a>
        <a href="{{ route('admin-create') }}">Create</a>
    </div>
@endsection
