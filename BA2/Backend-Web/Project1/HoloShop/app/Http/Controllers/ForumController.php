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
            $forum = Forum::getForum($id);
            if ($forum == null) {
                return redirect()->route('forum.index');
            }

            if (!$forum->canSee(auth()->user())) {
                return redirect()->route('forum.index');
            }

            return view('pages.forums.forum_page', [
                'forum' => $forum,
            ]);
    }
}
