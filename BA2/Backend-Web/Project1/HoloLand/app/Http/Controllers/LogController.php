<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Forum;
use App\Models\LoginLog;
use App\Models\Post;
use App\Models\ProfilePost;
use App\Models\Thread;

class LogController extends Controller
{
    public function login() {
        $logs = LoginLog::latestLogs();

        return view('admin.pages.logs.login', [
            'logs' => $logs
        ]);
    }

    public function activity() {
        $activities = Activity::latestLogs();

        return view('admin.pages.logs.activity', [
            'activities' => $activities
        ]);
    }

    public function threadPosts() {
        $posts = Post::latestLogs();

        return view('admin.pages.logs.posts', [
            'posts' => $posts
        ]);
    }

    public function profilePosts() {
        $posts = ProfilePost::latestLogs();

        return view('admin.pages.logs.profileposts', [
            'posts' => $posts
        ]);
    }

    public function threads() {
        $threads = Thread::latestLogs();

        return view('admin.pages.logs.threads', [
            'threads' => $threads
        ]);
    }

    public function forums() {
        $forums = Forum::latestLogs();

        return view('admin.pages.logs.forums', [
            'forums' => $forums
        ]);
    }
}
