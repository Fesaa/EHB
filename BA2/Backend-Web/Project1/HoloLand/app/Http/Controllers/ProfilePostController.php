<?php

namespace App\Http\Controllers;

use App\Models\ProfilePost;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (User::AuthUser() == null) {
            return redirect()->route("login");
        }


        $request->validate([
            "profile_id" => "required|exists:profiles,id",
            "profilepost_id" => "nullable|exists:profile_posts,id",
            "message" => "required|max:1000",
        ]);

        if ($request->input("profile_id") == null && $request->input("profilepost_id") == null) {
            return redirect('/404');
        }

        $profilePost = new ProfilePost();
        if ($request->input("profilepost_id") != null) {
            $profilePost->profile_post_id = $request->input("profilepost_id");
        } else if ($request->input("profile_id") != null) {
            $profilePost->profile_id = $request->input("profile_id");
        }
        $profilePost->user_id = User::AuthUser()->id;
        $profilePost->content = $request->input("message");
        $profilePost->save();

        return redirect()->route("profiles.show", ["profile" => $request->input("profile_id")]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
