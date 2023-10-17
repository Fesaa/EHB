<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// Registered under admin routes -> always authenticated and has role 'STAFF'
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('DASHBOARD_ROLES'))) {
            return redirect()->route('admin.dashboard');
        }

        $roles = Role::all()->sortByDesc('weight');
        $privileges = Privilege::all()->sortBy('id');

        return view('admin.pages.holoshop.roles', [
            'roles' => $roles,
            'privileges' => $privileges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Inline creation
        return redirect()->route('404');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented
        return redirect()->route('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Inline editing
        return redirect()->route('404');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!User::AuthUser()->hasPrivilege(Privilege::privilegeValueOf('ROLES_EDIT'))) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'role_id' => 'required|integer',
            'description' => 'string|nullable',
            'colour' => 'string|nullable',
            'title' => 'string|nullable|max:25',
            'weight' => 'integer|required',
        ])->validate();

        $role = Role::find(request()->input('role_id'));
        if ($role == null) {
            return redirect()->route('admin.roles.index');
        }

        return $this->setRoleFromRequest($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!User::AuthUser()->hasPrivilegeByString('ROLES_EDIT')) {
            return redirect()->route('home');
        }

        validator(request()->all(), [
            'role_id' => 'required|integer',
        ])->validate();

        $role = Role::find(request()->input('role_id'));
        if ($role == null) {
            return redirect()->route('admin.roles.index');
        }

        $role->delete();
        return redirect()->route('admin.roles.index');
    }

    private function setRoleFromRequest($role): RedirectResponse
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
        return redirect()->route('admin.roles.index');
    }
}
