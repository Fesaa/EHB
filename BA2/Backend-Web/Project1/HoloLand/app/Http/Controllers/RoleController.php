<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function update()
    {

        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('ROLES_EDIT'))) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'id' => 'required|integer',
            'description' => 'string|nullable',
            'colour' => 'string|nullable',
            'title' => 'string|nullable|max:25',
            'weight' => 'integer|required',
        ])->validate();

        $role = Role::find(request()->input('id'));
        if ($role == null) {
            return redirect()->route('admin.roles');
        }

        return $this->setRoleFromRequest($role);
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilegeByString('ROLES_EDIT')) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'description' => 'string|required',
            'colour' => 'string|required',
            'title' => 'string|required|max:25',
            'name' => 'string|required|max:25',
            'weight' => 'integer|required',
        ])->validate();

        $role = new Role();
        $role->name = request()->input('name');
        return $this->setRoleFromRequest($role);
    }

    public function destroy()
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!User::AuthUser()->hasPrivilegeByString('ROLES_EDIT')) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'id' => 'required|integer',
        ])->validate();

        $role = Role::find(request()->input('id'));
        if ($role == null) {
            return redirect()->route('admin.roles');
        }

        $role->delete();
        return redirect()->route('admin.roles');
    }

    private function setRoleFromRequest($role)
    {
        $privileges = Privilege::all();
        $value = 0;
        foreach ($privileges as $privilege) {
            if (request()->has($privilege->name)) {
                $value = $value | $privilege->value;
            }
        }
        $role->privilege = $value;
        $role->weight = request()->input('weight');
        $role->description = request()->input('description');
        $role->colour = request()->input('colour');
        $role->title = request()->input('title');

        $role->save();
        return redirect()->route('admin.roles');
    }

}
