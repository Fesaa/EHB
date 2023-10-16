<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private readonly Role $MEMBER;

    public function __construct()
    {
        $this->MEMBER = Role::where(['name' => 'MEMBER'])->first();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all()->sortBy('created_at');
        foreach ($users as $user) {
            $user->populateFields();
        }
        return view('pages.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (User::AuthUser() != null) {
            return redirect()->route('home');
        }

        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|min:4|max:25',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => request()->get('user'),
            'email' => request()->get('email'),
            'password' => bcrypt(request()->get('password')),
        ]);

        $user->roles()->attach($this->MEMBER);
        $user->save();

        if(auth()->attempt(request()->only('email', 'password'))) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Show the login screen
     */
    public function showLogin()
    {
        if (User::AuthUser() != null) {
            return redirect()->route('home');
        }

        return view('pages.users.login');
    }

    /**
     * Login the user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->tryLogin()) {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (User::AuthUser()->id != $id) {
            return redirect()->route('home');
        }

        return view('pages.users.dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (User::AuthUser()->id != $id) {
            return redirect()->route('home');
        }

        return view('pages.users.edit', [
            'user' => User::AuthUser(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if (User::AuthUser()->id != $id) {
            return redirect()->route('home');
        }

        $request->validate([
            'email' => 'nullable|email',
            'old-password' => 'required|min:8|max:255',
            'password' => 'nullable|min:8|max:255',
            'password-confirm' => 'nullable|same:password'
        ]);

        $user = User::AuthUser();

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
        return redirect()->route('users.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function ban() {
        return view('pages.status.ban');
    }
}
