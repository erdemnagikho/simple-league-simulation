<?php

namespace App\Services;

use Illuminate\Support\Collection;

class StandingService
{
    /**
     * @param Collection $teams
     * @param Collection $teamMatchesOrderedByWeek
     *
     * @return mixed
     */
    public function calculateDynamicStanding(Collection $teams, Collection $teamMatchesOrderedByWeek): mixed
    {
        $standings = [];
        foreach ($teams as $team) {
            $standings[$team->id] = [
                'team' => $team->name,
                'P' => 0, 'W' => 0, 'D' => 0, 'L' => 0, 'GD' => 0,
            ];
        }

        foreach ($teamMatchesOrderedByWeek as $match) {
            if (!$match->result) continue;
            $home = $match->home_team_id;
            $away = $match->away_team_id;
            $homeScore = $match->result->home_score;
            $awayScore = $match->result->away_score;

            $standings[$home]['GD'] += ($homeScore - $awayScore);
            $standings[$away]['GD'] += ($awayScore - $homeScore);

            if ($homeScore > $awayScore) {
                $standings[$home]['P'] += 3;
                $standings[$home]['W']++;
                $standings[$away]['L']++;
            } elseif ($homeScore < $awayScore) {
                $standings[$away]['P'] += 3;
                $standings[$away]['W']++;
                $standings[$home]['L']++;
            } else {
                $standings[$home]['P'] += 1;
                $standings[$away]['P'] += 1;
                $standings[$home]['D']++;
                $standings[$away]['D']++;
            }
        }

        return collect($standings)
            ->sortByDesc(fn($a) => [$a['P'], $a['GD'], $a['team']])
            ->values();
    }

    /**
     * @param Collection $standings
     *
     * @return mixed
     */
    public function calculateSimplePrediction(Collection $standings): mixed
    {
        $totalPoints = $standings->sum('P');

        $teamCount = $standings->count();

        return $standings->map(function ($team) use ($totalPoints, $teamCount) {
            $team['prediction'] = $totalPoints > 0
                ? round(($team['P'] / $totalPoints) * 100)
                : round(100 / $teamCount);
            return $team;
        })->values();
    }
}
