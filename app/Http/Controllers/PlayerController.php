<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class PlayerController extends Controller
{
    // Show all players with their QR codes
    public function index()
    {
        $players = Player::with('team')->get();
        $teams = Team::all();

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(250),
                new SvgImageBackEnd()
            )
        );

        $playerQrCodes = [];

        foreach ($players as $player) {
            $profileUrl = route('players.show', $player, true);

            $qrCode = $writer->writeString($profileUrl);

            $playerQrCodes[$player->id] = base64_encode($qrCode);
        }

        return view('players', compact(
            'players',
            'teams',
            'playerQrCodes'
        ));
    }

    // Show individual player profile
    public function show(Player $player)
    {
        $player->load('team');

        return view('player-profile', compact('player'));
    }

    // Add a new player
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        Player::create($validated);

        return redirect()
            ->route('players')
            ->with('success', 'Player added successfully! QR code generated.');
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
