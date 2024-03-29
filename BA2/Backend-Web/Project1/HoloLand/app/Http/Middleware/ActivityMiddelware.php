<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ActivityController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = User::AuthUser();
        if ($user != null) {
            ActivityController::createEntry($user->id, $request->url());
        }

        return $next($request);
    }
}
