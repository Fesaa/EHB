<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function login() {

        $logs = LoginLog::all();

        return view('admin.pages.logs.login', [
            'logs' => $logs
        ]);
    }
}
