<?php

namespace App\Http\Middleware;

use App\Models\Privilege;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModerationMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->url() == route('ban')) {
            return $next($request);
        }
        $user = User::AuthUser();
        if ($user != null) {
            if ($user->hasPrivilege(Privilege::privilegeValueOf('NOT_GLOBAL_SITE'))) {
                return redirect()->route('ban');
            }
        }

        return $next($request);
    }
}
