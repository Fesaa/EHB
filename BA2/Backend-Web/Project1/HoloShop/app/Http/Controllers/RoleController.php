<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;

class RoleController extends Controller
{
    public function updateDesc() {

        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('ROLE_EDIT_DESC'))) {
            return redirect()->route('home');
        }


        validator(request()->all(), [
            'description' => 'required|string|max:255',
            'id' => 'required|integer',
        ])->validate();

        $role = Role::find(request()->input('id'));
        if ($role == null) {
            return view('admin.pages.holoshop.roles', [
                'roles' => Role::all()->sortBy('id'),
                'privileges' => Privilege::all()->sortBy('id')
            ]);
        }
        $role->description = request()->input('description');
        $role->save();

        return view('admin.pages.holoshop.roles', [
            'roles' => Role::all()->sortBy('id'),
            'privileges' => Privilege::all()->sortBy('id')
        ]);
    }
}
