<?php

namespace App\Models;

use App\Observers\TeamObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TeamObserver::class])]
class Team extends Model
{
    protected $guarded = [];

    const ALL_TEAMS_CACHE_KEY = 'all_teams';
}
