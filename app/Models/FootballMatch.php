<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class FootballMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'status',
        'home_score',
        'away_score',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}