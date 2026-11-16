<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MatchReminderController extends Controller
{
    public function index(): JsonResponse
    {
        $reminders = DB::table('match_reminders')
            ->join('matches', 'match_reminders.match_id', '=', 'matches.id')
            ->join('teams as home_teams', 'matches.home_team_id', '=', 'home_teams.id')
            ->join('teams as away_teams', 'matches.away_team_id', '=', 'away_teams.id')
            ->whereNotNull('match_reminders.sent_at')
            ->where('matches.status', 'Scheduled')
            ->orderByDesc('match_reminders.sent_at')
            ->limit(10)
            ->select(
                'match_reminders.id',
                'match_reminders.sent_at',
                'matches.match_date',
                'matches.venue',
                'home_teams.name as home_team',
                'away_teams.name as away_team'
            )
            ->get();

        return response()->json($reminders);
    }
}
