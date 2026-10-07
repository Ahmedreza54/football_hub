<?php

namespace App\Http\Controllers;

use App\Models\FootballMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class FootballMatchController extends Controller
{
    public function index()
    {
        $matches = FootballMatch::with(['homeTeam', 'awayTeam'])
            ->latest('match_date')
            ->get();

        $teams = Team::orderBy('name')->get();

        return view('matches', compact('matches', 'teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        FootballMatch::create($validated);

        return redirect()
            ->route('matches')
            ->with('success', 'Match added successfully!');
    }

    public function destroy(FootballMatch $footballMatch)
    {
        $footballMatch->delete();

        return redirect()
            ->route('matches')
            ->with('success', 'Match deleted successfully!');
    }
}