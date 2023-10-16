@extends('layouts.master')

@section('main-content')
    @include('pages.forums.forms.base', [
    "method" => "POST",
    "route" => route('forums.store'),
    "forum" => null,
    "title" => "",
    "subtitle" => "",
    "description" => "",
    "cloaks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_CLOAK"),
    "locks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_LOCK"),
])
@endsection

@section('errors-title')
    Couldn't create forum
@endsection
