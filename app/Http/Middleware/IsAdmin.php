<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAdmin = false;

        if (Auth::user() && Auth::user()->isAdmin()) {
            $isAdmin = true;
        }

        if(!$isAdmin){
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
