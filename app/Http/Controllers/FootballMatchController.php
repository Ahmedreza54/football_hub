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
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
        ]);

        $match = FootballMatch::create($validated);

        if ($request->expectsJson()) {
            $match->load(['homeTeam', 'awayTeam']);

            return response()->json([
                'message' => 'Match added successfully!',
                'match' => $match,
            ], 201);
        }

        return redirect()
            ->route('matches')
            ->with('success', 'Match added successfully!');
    }

    public function edit(FootballMatch $footballMatch)
    {
        $teams = Team::orderBy('name')->get();

        return view('matches.edit', compact('footballMatch', 'teams'));
    }

    public function update(Request $request, FootballMatch $footballMatch)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
        ]);

        $footballMatch->update($validated);

        return redirect()
            ->route('matches')
            ->with('success', 'Match updated successfully!');
    }

   public function destroy(Request $request, FootballMatch $footballMatch)
{
    $matchId = $footballMatch->id;

    $footballMatch->delete();

    if ($request->expectsJson()) {
        return response()->json([
            'message' => 'Match deleted successfully!',
            'id' => $matchId,
        ]);
    }

    return redirect()
        ->route('matches')
        ->with('success', 'Match deleted successfully!');
}
}
