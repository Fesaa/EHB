<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Thread;
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

    public function thread(int $id) {
        $thread = Thread::getThread($id);
        if ($thread == null) {
            return redirect()->route('forum.index');
        }

        if (!$thread->canSee(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        return view('pages.forums.thread_page', [
            'thread' => $thread,
        ]);
    }
}
