<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    public function handle() {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        if (!auth()->user()->hasPrivilege(Privilege::privilegeValueOf('PRIVILEGES_EDIT'))) {
            return redirect()->route('home');
        }


        validator(request()->all(), [
            'description' => 'required|string|max:255',
            'id' => 'required|integer',
        ])->validate();

        static::update(request('id'), request('description'));

        return view('admin.pages.holoshop.privileges', [
            'privileges' => Privilege::all()->sortBy('id')
        ]);
    }

    private static function update(int $id, string $description): void {
        $privilege = Privilege::find($id);
        if ($privilege == null) {
            return;
        }
        $privilege->description = $description;
        $privilege->save();
    }
}
