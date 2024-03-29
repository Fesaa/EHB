<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthController extends Controller
{

    public function show() {
        return view('layouts.login');
    }

    public function login() {
        validator(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();


        if(auth()->attempt(request()->only('email', 'password'))) {
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
        return view('layouts.register');
    }

    public function register() {
        validator(request()->all(), [
            'user' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        User::create([
            'name' => request()->get('user'),
            'email' => request()->get('email'),
            'password' => bcrypt(request()->get('password'))
        ])->save();

        if(auth()->attempt(request()->only('email', 'password'))) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

}
