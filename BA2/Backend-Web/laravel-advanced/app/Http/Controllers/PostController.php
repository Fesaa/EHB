<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('layouts.master', [
            'posts' => $posts
        ]);
    }

    public function show() {
        return view('layouts.post');
    }

    public function newPost() {

        if (auth()->user() == null) {
            return redirect('/register');
        }

        validator(request()->all(), [
            'title' => 'required|min:4|max:50',
            'content' => 'required|min:4'
        ])->validate();

        $post = new Post();
        $post->title = request()->get('title');
        $post->content = request()->get('content');
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/');
    }
}
