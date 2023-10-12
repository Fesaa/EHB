<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;

class AuthController extends Controller
{

    public function ban() {
        if (auth()->user() != null) {
            if (!auth()->user()->hasPrivilege(Privilege::getPrivilegeValue('NOT_GLOBAL_SITE'))) {
                return redirect()->route('home');
            }
        }
        return view('pages.ban');
    }

    public function show() {
        return view('pages.forms.login');
    }

    private function tryLogin(): bool {
        if(auth()->attempt(request()->only('email', 'password'))) {
            LoginLog::create([
                'email' => request()->get('email'),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'success' => true
            ])->save();
            return true;
        }
        LoginLog::create([
            'email' => request()->get('email'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'success' => false
        ])->save();

       return false;
    }

    public function login() {
        validator(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if ($this->tryLogin()) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function showRegister() {
        return view('pages.forms.register');
    }

    public function register() {
        validator(request()->all(), [
            'user' => 'required|min:4|max:25',
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $user = User::create([
            'name' => request()->get('user'),
            'email' => request()->get('email'),
            'password' => bcrypt(request()->get('password')),
        ])->save();

        $member = Role::where(['name' => 'MEMBER'])->first();
        $user->roles()->attach($member);

        if(auth()->attempt(request()->only('email', 'password'))) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

}
