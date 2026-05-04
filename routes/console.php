<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('tasks:generate')->dailyAt('00:01')->withoutOverlapping();
Schedule::command('tasks:calculate-bonus')->dailyAt('01:00')->withoutOverlapping();