<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SimulateService
{
    /**
     * @param Collection $matches
     *
     * @return void
     */
    public function simulate(Collection $matches): void
    {
        foreach ($matches as $match) {
            $homeStrength = $match->homeTeam->strength ?? 1;
            $awayStrength = $match->awayTeam->strength ?? 1;

            $homeBase = rand(0, 2);
            $awayBase = rand(0, 2);

            $strengthDiff = $homeStrength - $awayStrength;
            if ($strengthDiff > 0) {
                $homeBonus = rand(0, $strengthDiff);
                $awayBonus = 0;
            } elseif ($strengthDiff < 0) {
                $homeBonus = 0;
                $awayBonus = rand(0, abs($strengthDiff));
            } else {
                $homeBonus = $awayBonus = 0;
            }

            $homeScore = $homeBase + $homeBonus;
            $awayScore = $awayBase + $awayBonus;

            $homeScore = min($homeScore, 5);
            $awayScore = min($awayScore, 5);

            $match->result()->create([
                'home_score' => $homeScore,
                'away_score' => $awayScore,
            ]);

            $match->played = true;
            $match->save();
        }
    }
}
