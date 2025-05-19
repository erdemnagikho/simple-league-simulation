<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResult extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(TeamMatch::class);
    }
}
