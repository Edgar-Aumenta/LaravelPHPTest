<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers;

class Decrypt
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
        $encrypted = $request['encrypted'];
        if($encrypted)

        {
            $request['password'] = (new Helpers)->decryptSo($request['password'], 'PCSWebLogin123456789012345678901');
        }                       

        return $next($request);
    }
}
