<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FootballApiService;
use App\Models\Team;
use App\Models\Player;
use App\Models\FootballMatch;
use Illuminate\Support\Facades\Log;
use Throwable;

class HomeController extends Controller
{
    public function index(Request $request, FootballApiService $footballApi)
    {
        // Default API values
        $fixtures = [];
        $apiAvailable = false;
        $apiError = null;

        // Get today's football fixtures
        try {
            $apiResponse = $footballApi->get('fixtures', [
                'date' => now('Europe/London')->toDateString(),
                'timezone' => 'Europe/London',
            ]);

            if (!$apiResponse->successful()) {
                Log::error('Football API returned an unsuccessful response.', [
                    'http_status' => $apiResponse->status(),
                ]);

                $apiError = 'Football information is temporarily unavailable. Please try again later.';
            } else {
                $apiData = $apiResponse->json();

                $apiErrors = data_get($apiData, 'errors', []);

                $responseFixtures = data_get($apiData, 'response');

                if (!empty($apiErrors) || !is_array($responseFixtures)) {
                    Log::error('Football API returned invalid or error data.', [
                        'api_errors' => $apiErrors,
                    ]);

                    $apiError = 'We could not retrieve football information at the moment. Please try again later.';
                } else {
                    $fixtures = $responseFixtures;
                    $apiAvailable = true;
                }
            }

        } catch (Throwable $exception) {
            Log::error('Football API connection failed.', [
                'message' => $exception->getMessage(),
            ]);

            $apiError = 'Unable to connect to the football service. Please check your connection and try again.';
        }

        // Separate fixtures by API status
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

        // Search teams and players
        $search = trim($request->query('search', ''));

        $teamResults = collect();
        $playerResults = collect();

        if ($search !== '') {
            $teamResults = Team::where('name', 'like', "%{$search}%")
                ->orWhere('country', 'like', "%{$search}%")
                ->orderBy('name')
                ->limit(10)
                ->get();

            $playerResults = Player::with('team')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        return view('home', compact(
            'fixtures',
            'liveFixtures',
            'upcomingFixtures',
            'finishedFixtures',
            'apiAvailable',
            'apiError',
            'totalTeams',
            'totalPlayers',
            'totalMatches',
            'completedMatches',
            'search',
            'teamResults',
            'playerResults'
        ));
    }
}
