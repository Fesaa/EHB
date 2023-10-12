<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->isStaff()) {
            return redirect()->route('admin.pages.index');
        }

        return view('admin.pages.index');
    }

    public function logs() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('DASHBOARD_LOGS'))) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.pages.logs.empty');
    }

    public function privileges() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('DASHBOARD_PRIVILEGES'))) {
            return redirect()->route('admin.dashboard');
        }

        $privileges = Privilege::all()->sortBy('id');

        return view('admin.pages.holoshop.privileges', [
            'privileges' => $privileges
        ]);
    }

    public function roles() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('DASHBOARD_ROLES'))) {
            return redirect()->route('admin.dashboard');
        }

        $roles = Role::all()->sortBy('id');
        $privileges = Privilege::all()->sortBy('id');

        return view('admin.pages.holoshop.roles', [
            'roles' => $roles,
            'privileges' => $privileges
        ]);
    }
}
