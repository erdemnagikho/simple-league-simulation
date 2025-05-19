<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMatch extends Model
{
    protected $guarded = [];

    const ALL_MATCHES_ORDER_BY_WEEK_CACHE_KEY = 'all_matches_order_by_week';
    const ALL_PLAYED_CACHE_KEY = 'all_played';
    const TOTAL_WEEKS = 'total_weeks';

    /**
     * @return HasOne
     */
    public function result(): HasOne
    {
        return $this->hasOne(MatchResult::class);
    }

    /**
     * @return BelongsTo
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * @return BelongsTo
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
