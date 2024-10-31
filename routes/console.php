<?php

use App\Console\Commands\CleanExpiredAndDuplicateSessions;
use App\Console\Commands\CleanOldSoftDeletedSkillCategory;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


// route for console/command/CleanExpiredSessions
Schedule::command(CleanExpiredAndDuplicateSessions::class)
        ->cron('0 0 */3 * *');  // Setiap 3 hari

        Schedule::command(CleanOldSoftDeletedSkillCategory::class)
        ->hourly();  // Setiap 1 jam

