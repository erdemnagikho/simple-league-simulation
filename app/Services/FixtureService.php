<?php

namespace App\Services;

class FixtureService
{
    /**
     * @param $teams
     *
     * @return array
     */
    public function generateFixture($teams): array
    {
        $teamIds = $teams->pluck('id')->toArray();
        $numTeam = count($teamIds);

        $isOdd = $numTeam % 2 !== 0;
        if ($isOdd) {
            $teamIds[] = null; //It represents a team that is not playing
            $numTeam++;
        }

        $numRounds = $numTeam - 1;
        $matchesPerRound = $numTeam / 2;
        $fixtures = [];

        for ($round = 0; $round < $numRounds; $round++) {
            $week = [];
            for ($i = 0; $i < $matchesPerRound; $i++) {
                $home = $teamIds[$i];
                $away = $teamIds[$numTeam - 1 - $i];
                if ($home !== null && $away !== null) {
                    $week[] = [$home, $away];
                }
            }

            $teamIds = array_merge(
                [$teamIds[0]],
                [end($teamIds)],
                array_slice($teamIds, 1, -1)
            );
            $fixtures[] = $week;
        }

        $secondHalf = [];
        foreach ($fixtures as $week) {
            $secondWeek = [];
            foreach ($week as [$home, $away]) {
                $secondWeek[] = [$away, $home];
            }
            $secondHalf[] = $secondWeek;
        }

        return array_merge($fixtures, $secondHalf);
    }
}
