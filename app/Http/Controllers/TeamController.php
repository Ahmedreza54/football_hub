<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Show all teams
    public function index()
    {
        $teams = Team::latest()->get();

        return view('teams', compact('teams'));
    }

    // Add a new team
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Team::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return redirect()
            ->route('teams')
            ->with('success', 'Team added successfully!');
    }

    // Delete a team
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()
            ->route('teams')
            ->with('success', 'Team deleted successfully!');
    }
}