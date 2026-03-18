<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EnsureUserSelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
        // if (!session()->has('user_id')) {
            return redirect()->route('user.select');
        }

        return $next($request);
    }
}