<?php

use Illuminate\Support\Facades\Cache;

class TrackActivity
{
    public function handle($request, Closure $next)
    {
        $timestamp = now()->timestamp;

        Cache::put('last_activity', $timestamp, 3600);

        file_put_contents('/tmp/last_activity', $timestamp);

        return $next($request);
    }
}