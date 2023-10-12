<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\LoginLog;

class LogController extends Controller
{
    public function login() {

        $logs = LoginLog::all()
            ->sortByDesc('created_at');

        return view('admin.pages.logs.login', [
            'logs' => $logs
        ]);
    }

    public function activity() {

        $activities = Activity::all()->sortByDesc('created_at');

        return view('admin.pages.logs.activity', [
            'activities' => $activities
        ]);
    }
}
