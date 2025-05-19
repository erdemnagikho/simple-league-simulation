<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\TeamService;
use App\Services\TeamMatchService;
use App\Http\Controllers\Controller;

class ResetController extends Controller
{
    protected TeamService $teamService;
    protected TeamMatchService $teamMatchService;

    public function __construct(TeamService $teamService, TeamMatchService $teamMatchService)
    {
        $this->teamService = $teamService;
        $this->teamMatchService = $teamMatchService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $this->teamMatchService->resetMatches();

        $teams = $this->teamService->getTeams();

        $matchesOrderedByWeek = $this->teamMatchService->getTeamMatchesOrderedByWeek();

        $weeks = $matchesOrderedByWeek->groupBy('week');

        $standings = collect($teams)->map(function ($team) use ($teams) {
            return [
                'team' => $team->name,
                'P' => 0, 'W' => 0, 'D' => 0, 'L' => 0, 'GD' => 0, 'prediction' => 100 / count($teams)
            ];
        });

        $currentWeek = $this->teamMatchService->getCurrentWeek($matchesOrderedByWeek);

        return Inertia::render('Admin/Simulation/Start', [
            'standings' => $standings,
            'weeks' => $weeks,
            'currentWeek' => $currentWeek,
            'currentWeekMatches' => $weeks[$currentWeek] ?? [],
            'allPlayed' => false,
        ]);
    }
}
