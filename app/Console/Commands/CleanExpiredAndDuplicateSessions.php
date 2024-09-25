<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserManagement;
use App\Models\Sessions;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanExpiredAndDuplicateSessions extends Command
{
    protected $signature = 'sessions:clean';
    protected $description = 'Clean expired sessions and handle multiple sessions for the same user.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get session lifetime from configuration (in minutes)
        $sessionLifetime = (int) config('session.lifetime');

        // Fetch all sessions
        $sessions = Sessions::all();

        // Group sessions by user_id
        $groupedSessions = $sessions->groupBy('user_id');

        foreach ($groupedSessions as $userId => $userSessions) {
            // Skip if user_id is null (user logged out)
            if ($userId === null) {
                continue;
            }

            // Get the latest session for the user
            $latestSession = $userSessions->sortByDesc('last_activity')->first();
            
            // Check if the session is expired
            $lastActivity = Carbon::parse($latestSession->last_activity);
            $expired = $lastActivity->addMinutes($sessionLifetime)->isPast();

         
            // delete session where user_id is null
            if ($userId === null) {
                DB::table('sessions')->where('user_id', $userId)->delete();
            // } else if ($expired) {
            //     // If session expired, delete all sessions for this user
            //     DB::table('sessions')->where('user_id', $userId)->delete();
            } else {
                // If session is not expired, check if there are multiple sessions
                // If there are multiple sessions, keep only the latest one
                if ($userSessions->count() > 1) {
                    // Delete all sessions except the latest one
                    DB::table('sessions')
                        ->where('user_id', $userId)
                        ->where('id', '!=', $latestSession->id)
                        ->delete();
                }
            }
                // If there are multiple sessions, keep only the latest one
                if ($userSessions->count() > 1) {
                    // Delete all sessions except the latest one
                    DB::table('sessions')
                        ->where('user_id', $userId)
                        ->where('id', '!=', $latestSession->id)
                        ->delete();
                
            }
        }

        $this->info('Expired sessions cleaned and multiple sessions handled successfully.');
    }
}
