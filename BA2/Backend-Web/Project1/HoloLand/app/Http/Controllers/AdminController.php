<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->isStaff()) {
            return redirect()->route('admin.pages.index');
        }

        return view('admin.pages.index');
    }

    public function logs() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_LOGS'))) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.pages.logs.empty');
    }

    public function privileges() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_PRIVILEGES'))) {
            return redirect()->route('admin.dashboard');
        }

        $privileges = Privilege::all()->sortBy('id');

        return view('admin.pages.hololand.privileges', [
            'privileges' => $privileges
        ]);
    }

    public function roles() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_ROLES'))) {
            return redirect()->route('admin.dashboard');
        }

        $roles = Role::all()->sortByDesc('weight');
        $privileges = Privilege::all()->sortBy('id');

        return view('admin.pages.hololand.roles', [
            'roles' => $roles,
            'privileges' => $privileges
        ]);
    }

    public function members() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_MEMBERS'))) {
            return redirect()->route('admin.dashboard');
        }

        $members = User::all()->sortBy('id');
        return view('admin.pages.moderation.members', [
            'members' => $members
        ]);
    }

    public function update_roles() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('MEMBERS_EDIT_ROLES'))) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'id' => 'required|integer',
        ])->validate();

        $user = User::find(request()->input('id'));
        if (!$user) {
            return redirect()->route('admin.pages.moderation.members');
        }

        $user->roles()->detach();
        $roles = Role::all();
        foreach ($roles as $role) {
            if (request()->has($role->name)) {
                $user->roles()->attach($role->id);
            }
        }
        $user->save();

        $members = User::all()->sortBy('id');
        return view('admin.pages.moderation.members', [
            'members' => $members
        ]);
    }

    public function punishments() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_PUNISHMENTS'))) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.pages.moderation.punishments', [
            'members' => User::all()->sortBy('id')
        ]);
    }

    public function ban(Request $request) {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('PUNISHMENTS_ISSUE'))) {
            return redirect()->route('home');
        }

        $request->validate([
            "id" => "required|integer"
        ]);
        $id = $request->input('id');

        $user = User::getUser($id);
        if ($user == null) {
            return redirect()->route('admin.punishments');
        }
        if (!User::AuthUser()->canPunish($user)) {
            return redirect()->route('admin.punishments')->withErrors('You cannot ban ' . $user->name . ".");
        }

        $BAN_ROLE = Role::where('name', 'BANNED')->first();
        $user->roles()->attach($BAN_ROLE);
        $user->save();

        return redirect()->route('admin.punishments');
    }

    public function unban(Request $request) {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('PUNISHMENTS_ISSUE'))) {
            return redirect()->route('home');
        }

        $request->validate([
            "id" => "required|integer"
        ]);
        $id = $request->input('id');

        $user = User::getUser($id);

        if ($user == null) {
            return redirect()->route('admin.punishments');
        }

        if (!$user->banned()) {
            return redirect()->route('admin.punishments')->withErrors($user->name . ' is not banned.');
        }

        if (!User::AuthUser()->canPunish($user)) {
            return redirect()->route('admin.punishments')->withErrors('You cannot unban ' . $user->name . ".");
        }

        $BAN_ROLE = Role::where('name', 'BANNED')->first();
        $user->roles()->detach($BAN_ROLE);
        $user->save();

        return redirect()->route('admin.punishments');
    }
}
