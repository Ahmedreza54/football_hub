<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Show all teams and handle AJAX search
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $teams = Team::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        // Return JSON for AJAX / Fetch requests
        if ($request->expectsJson()) {
            return response()->json([
                'teams' => $teams,
            ]);
        }

        return view('teams', compact('teams', 'search'));
    }

    // Add a new team
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Team::create($validated);

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
