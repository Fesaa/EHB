<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\LoginLog;

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
}
