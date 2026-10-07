<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    // Show all players
    public function index()
    {
        $players = Player::with('team')->get();
        $teams = Team::all();

        return view('players', compact('players', 'teams'));
    }

    // Add a new player
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        Player::create([
            'name' => $request->name,
            'position' => $request->position,
            'team_id' => $request->team_id,
        ]);

        return redirect()
            ->route('players')
            ->with('success', 'Player added successfully!');
    }

    // Delete a player
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()
            ->route('players')
            ->with('success', 'Player deleted successfully!');
    }
}