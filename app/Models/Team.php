<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FootballMatch;

class Team extends Model
{
    protected $fillable = [
        'name',
        'country',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(FootballMatch::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(FootballMatch::class, 'away_team_id');
    }
}