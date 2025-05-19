<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    const ALL_TEAMS_CACHE_KEY = 'all_teams';
}
