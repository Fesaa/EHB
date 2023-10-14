<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index() {

        $forums = Forum::getVisibleForums(User::AuthUser());

        return view('pages.forums.index', [
            'forums' => $forums,
        ]);
    }

    public function forum(int $id) {
            $forum = Forum::getForum($id);
            if ($forum == null) {
                return redirect()->route('forum.index');
            }

            if (!$forum->canSee(User::AuthUser())) {
                return redirect()->route('forum.index');
            }

            return view('pages.forums.forum_page', [
                'forum' => $forum,
            ]);
    }
}
