<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class CommentController extends Controller
{
    public function newComment() {
        if (auth()->user() == null) {
            return redirect('/register');
        }

        validator(request()->all(), [
            'content' => 'required|min:4',
            'post_id' => 'required'
        ])->validate();

        $comment = new Comment();
        $comment->content = request()->get('content');
        $comment->user_id = auth()->user()->id;
        $comment->post_id = request()->get('post_id');
        $comment->save();

        return redirect('/');
    }
}
