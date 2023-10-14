<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return view('pages.account.dashboard');
    }

    public function security() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return view('pages.forms.edit_user', [
            'user' => User::AuthUser()
        ]);
    }

    public function update() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = User::AuthUser();

        validator(request()->all(), [
            'email' => 'nullable|email',
            'old-password' => 'required|min:8|max:255',
            'password' => 'nullable|min:8|max:255',
            'password-confirm' => 'nullable|same:password'
        ])->validate();


        if (!auth()->attempt([
            'email' => $user->email,
            'password' => request()->get('old-password')
        ])) {
            return redirect()->back()->withErrors([
                'Authentication' => 'The provided password does not match our records.'
            ]);
        }

        if (request()->has('email')) {
            $user->email = request()->get('email');
        }

        if (request()->has('password')) {
            if (!request()->has('password-confirm')) {
                return redirect()->back()->withErrors([
                    'password-confirm' => 'Please confirm your new password.'
                ]);
            }
            if (request()->has('password')) {
                $user->password = bcrypt(request()->get('password'));
            }
        }
        $user->save();
        return redirect()->route('account');
    }


    public function members() {
        $users = User::all()->sortBy('created_at');
        return view('pages.members', [
            'users' => $users
        ]);
    }

    public static function getTodaysBirthDays(): array {
        $users = User::all()->sortBy('created_at');
        $birthdays = [];
        foreach ($users as $user) {
            $profile = $user->profile();
            if ($profile->isBirthday()) {
                $birthdays[] = $user;
            }
        }
        return $birthdays;
    }
}
