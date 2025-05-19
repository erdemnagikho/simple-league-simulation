<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Collection;
class TeamService
{
    /**
     * @return Collection
     */
    public function getTeams(): Collection
    {
        $teams = smartCache()->getJson(Team::ALL_TEAMS_CACHE_KEY);
        if ($teams) {
            return collect($teams);
        }

        $teams = Team::all();

        smartCache()->setJson(Team::ALL_TEAMS_CACHE_KEY, $teams);

        return $teams;
    }
}
