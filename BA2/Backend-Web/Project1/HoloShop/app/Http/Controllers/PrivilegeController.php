<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    public function update() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('PRIVILEGES_EDIT'))) {
            return redirect()->route('home');
        }


        validator(request()->all(), [
            'description' => 'required|string|max:255',
            'id' => 'required|integer',
        ])->validate();

        $privilege = Privilege::find(request()->input('id'));
        if ($privilege == null) {
            return view('admin.pages.holoshop.privileges', [
                'privileges' => Privilege::all()->sortBy('id')
            ]);
        }
        $privilege->description = request()->input('description');
        $privilege->save();

        return view('admin.pages.holoshop.privileges', [
            'privileges' => Privilege::all()->sortBy('id')
        ]);
    }
}
