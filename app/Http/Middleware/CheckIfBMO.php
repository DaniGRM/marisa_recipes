<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckIfBMO
{
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $explodeUserAgent = explode(' ', $userAgent);
        
        if(!$request->post() && $explodeUserAgent[2] == 'CrOS'){
            if(request()->routeIs('bmo.*')){
                return $next($request);
            }
            return redirect()->route('bmo');
        }

        return $next($request);
    }
}