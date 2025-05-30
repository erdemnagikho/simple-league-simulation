<?php

namespace App\Observers;

use App\Models\Team;

class TeamObserver
{
    /**
     * Handle the Team "created" event.
     */
    public function created(Team $team): void
    {
        smartCache()->del(Team::ALL_TEAMS_CACHE_KEY);
    }

    /**
     * Handle the Team "updated" event.
     */
    public function updated(Team $team): void
    {
        smartCache()->del(Team::ALL_TEAMS_CACHE_KEY);
    }

    /**
     * Handle the Team "deleted" event.
     */
    public function deleted(Team $team): void
    {
        smartCache()->del(Team::ALL_TEAMS_CACHE_KEY);
    }

    /**
     * Handle the Team "restored" event.
     */
    public function restored(Team $team): void
    {
        //
    }

    /**
     * Handle the Team "force deleted" event.
     */
    public function forceDeleted(Team $team): void
    {
        //
    }
}
