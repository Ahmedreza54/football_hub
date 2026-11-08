<?php

namespace App\Http\Controllers;

use App\Services\FootballApiService;
use App\Models\Team;
use App\Models\Player;
use App\Models\FootballMatch;

class HomeController extends Controller
{
    public function index(FootballApiService $footballApi)
    {
        // Get today's football fixtures from the API
        $apiResponse = $footballApi->get('fixtures', [
            'date' => now('Europe/London')->toDateString(),
            'timezone' => 'Europe/London',
        ]);

        $fixtures = $apiResponse->successful()
            ? $apiResponse->json('response', [])
            : [];

        // Separate fixtures by their API status codes
        $liveFixtures = collect($fixtures)->filter(function ($fixture) {
            return in_array(data_get($fixture, 'fixture.status.short'), [
                '1H', 'HT', '2H', 'ET', 'BT', 'P', 'LIVE'
            ]);
        })->values();

        $finishedFixtures = collect($fixtures)->filter(function ($fixture) {
            return in_array(data_get($fixture, 'fixture.status.short'), [
                'FT', 'AET', 'PEN'
            ]);
        })->values();

        $upcomingFixtures = collect($fixtures)->filter(function ($fixture) {
            return in_array(data_get($fixture, 'fixture.status.short'), [
                'NS', 'TBD'
            ]);
        })->values();

        // Dashboard statistics
        $totalTeams = Team::count();
        $totalPlayers = Player::count();
        $totalMatches = FootballMatch::count();

        $completedMatches = FootballMatch::where('status', 'Completed')
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->count();

        return view('home', compact(
            'fixtures',
            'liveFixtures',
            'upcomingFixtures',
            'finishedFixtures',
            'totalTeams',
            'totalPlayers',
            'totalMatches',
            'completedMatches'
        ));
    }
}
