<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index() {

        $forums = Forum::getVisibleForums(auth()->user());

        return view('pages.forums.index', [
            'forums' => $forums,
        ]);
    }

    public function forum(int $id) {
            $forum = Forum::where(["id" => $id])->first();
            if ($forum == null) {
                return redirect()->route('forum.index');
            }

            return view('pages.forums.forum_page', [
                'forum' => $forum,
            ]);
    }
}
