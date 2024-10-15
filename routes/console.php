<?php

use App\Console\Commands\CleanExpiredAndDuplicateSessions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// route for console/command/CleanExpiredSessions

Schedule::command(CleanExpiredAndDuplicateSessions::class)->everyMinute();;
