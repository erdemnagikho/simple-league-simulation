<?php

namespace App\Services;

use App\Models\TeamMatch;
use Illuminate\Support\Collection;

class TeamMatchService
{
    /**
     * @param array $matchWeeks
     *
     * @return void
     */
    public function insertTeamMatches(array $matchWeeks): void
    {
        foreach ($matchWeeks as $weekIndex => $matches) {
            foreach ($matches as [$home, $away]) {
                if ($home && $away) {
                    TeamMatch::query()
                        ->create([
                            'home_team_id' => $home,
                            'away_team_id' => $away,
                            'week' => $weekIndex + 1,
                        ]);
                }
            }
        }

        smartCache()->setJson(TeamMatch::TOTAL_WEEKS, count($matchWeeks));
    }

    /**
     * @return Collection
     */
    public function getTeamMatchesOrderedByWeek(): Collection
    {
        return TeamMatch::query()
            ->with(['homeTeam', 'awayTeam', 'result'])
            ->orderBy('week')
            ->get();
    }

    /**
     * @return int|null
     */
    public function getFirstWeekWithoutResult(): int|null
    {
        return TeamMatch::query()
            ->whereDoesntHave('result')
            ->orderBy('week')
            ->first()->week ?? null;
    }

    /**
     * @param int $week
     *
     * @return Collection
     */
    public function getTeamMatchesByWeek(int $week): Collection
    {
        return TeamMatch::query()
            ->where('week', $week)
            ->with(['homeTeam', 'awayTeam', 'result'])
            ->get();
    }

    /**
     * @param Collection $teamMatchesOrderedByWeek
     *
     * @return mixed
     */
    public function getCurrentWeek(Collection $teamMatchesOrderedByWeek): mixed
    {
        $totalWeeks = smartCache()->getJson(TeamMatch::TOTAL_WEEKS);

        return $teamMatchesOrderedByWeek
            ->whereNull('result')
            ->groupBy('week')
            ->keys()
            ->first() ?? $totalWeeks;
    }

    /**
     * @return Collection
     */
    public function getAllUnPlayedMatchesOrderedByWeek(): Collection
    {
        return TeamMatch::query()
            ->whereDoesntHave('result')
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('week')
            ->get();
    }

    public function resetMatches(): void
    {
        foreach (TeamMatch::with('result')->get() as $match) {
            if ($match->result) {
                $match->result()->delete();
            }
            $match->played = false;
            $match->save();
        }
    }
}
