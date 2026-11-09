<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\FootballMatch;

class LeagueTableController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        $table = [];

        foreach ($teams as $team) {
            $played = 0;
            $won = 0;
            $drawn = 0;
            $lost = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;
            $points = 0;

            $matches = FootballMatch::where('status', 'Completed')
                ->where(function ($query) use ($team) {
                    $query->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })
                ->whereNotNull('home_score')
                ->whereNotNull('away_score')
                ->get();

            foreach ($matches as $match) {
                $played++;

                if ($match->home_team_id == $team->id) {
                    $goalsFor += $match->home_score;
                    $goalsAgainst += $match->away_score;

                    if ($match->home_score > $match->away_score) {
                        $won++;
                        $points += 3;
                    } elseif ($match->home_score == $match->away_score) {
                        $drawn++;
                        $points += 1;
                    } else {
                        $lost++;
                    }
                } else {
                    $goalsFor += $match->away_score;
                    $goalsAgainst += $match->home_score;

                    if ($match->away_score > $match->home_score) {
                        $won++;
                        $points += 3;
                    } elseif ($match->away_score == $match->home_score) {
                        $drawn++;
                        $points += 1;
                    } else {
                        $lost++;
                    }
                }
            }

            $table[] = [
                'team' => $team->name,
                'played' => $played,
                'won' => $won,
                'drawn' => $drawn,
                'lost' => $lost,
                'gf' => $goalsFor,
                'ga' => $goalsAgainst,
                'gd' => $goalsFor - $goalsAgainst,
                'points' => $points,
            ];
        }

        // Sort by points, goal difference, then goals scored.
        $table = collect($table)->sort(function ($a, $b) {
            return ($b['points'] <=> $a['points'])
                ?: ($b['gd'] <=> $a['gd'])
                ?: ($b['gf'] <=> $a['gf'])
                ?: strcmp($a['team'], $b['team']);
        })->values();

        return view('league-table', compact('table'));
    }
}
