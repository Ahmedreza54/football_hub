<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class Player extends Model
{
    protected $fillable = [
        'name',
        'position',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}