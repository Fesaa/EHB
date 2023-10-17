<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('home');
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
            return redirect()->route('home');
        }

        $request->validate([
            "thread_id" => "required|integer|exists:threads,id",
            "content" => "required|string",
       ]);

        $post = new Post();
        $post->thread_id = $request->input('thread_id');
        $post->content = $request->input('content');
        $post->user_id = User::AuthUser()->id;
        $post->save();

        return redirect()->to(route('threads.show', ['thread' => $post->thread_id]) . "#thread-post-" . $post->id);
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
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $post = Post::getPost($id);

        if ($post == null) {
            return redirect()->route('404');
        }

        if (!$post->canEdit(User::AuthUser())) {
            return redirect()->route('home');
        }

        return view('pages.posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $request->validate([
            "thread_id" => "required|integer|exists:threads,id",
            "content" => "required|string",
        ]);

        $post = Post::getPost($id);

        if ($post == null) {
            return redirect()->route('404');
        }

        if (!$post->canEdit(User::AuthUser())) {
            return redirect()->route('home');
        }

        if ($request->get('content') != null) {
            $post->content = $request->get('content');
        }

        $post->save();

        return redirect()->to(route('threads.show', ['thread' => $post->thread_id]) . "#thread-post-" . $post->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
