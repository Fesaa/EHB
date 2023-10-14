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

        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('ROLES_EDIT_PRIVILEGES'))) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'id' => 'required|integer',
            'description' => 'string|nullable',
            'colour' => 'string|nullable',
            'title' => 'string|nullable|max:25',
        ])->validate();

        $role = Role::find(request()->input('id'));
        if ($role == null) {
            return view('admin.pages.holoshop.roles', [
                'roles' => Role::all()->sortBy('id'),
                'privileges' => Privilege::all()->sortBy('id')
            ]);
        }

        $privilege = Privilege::all();
        $value = 0;
        foreach ($privilege as $privilege) {
            if (request()->has($privilege->name)) {
                $value = $value | $privilege->value;
            }
        }
        $role->privilege = $value;

        if (request()->has('description')) {
            $role->description = request()->input('description');
        }
        if (request()->has('colour')) {
            $role->colour = request()->input('colour');
        }
        if (request()->has('title')) {
            $role->title = request()->input('title');
        }

        $role->save();
        return redirect()->back();
    }

}
