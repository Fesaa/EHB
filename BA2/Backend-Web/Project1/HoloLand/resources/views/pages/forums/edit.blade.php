@extends('layouts.master')

@section('main-content')
    @include('pages.forums.forms.base', [
    "method" => "PUT",
    "route" => route('forums.update', $forum->id),
    "forum" => $forum,
    "title" => $forum->title,
    "subtitle" => $forum->subtitle,
    "description" => $forum->description,
    "cloaks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_CLOAK"),
    "locks" => \App\Models\User::AuthUser()->hasPrivilegeByString("FORUM_LOCK"),
    "autoCloaks" => \App\Models\User::AuthUser()->hasPrivilegeByString("THREAD_CLOAK"),
    "autoLocks" => \App\Models\User::AuthUser()->hasPrivilegeByString("THREAD_LOCK"),
    "fields" => $forum->getFormFields(),
])
@endsection

@section('errors-title')
    Couldn't create forum
@endsection
