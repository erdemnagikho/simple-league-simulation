<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\TeamService;
use App\Services\StandingService;
use App\Services\TeamMatchService;
use App\Http\Controllers\Controller;

class StartSimulationController extends Controller
{
    protected TeamService $teamService;
    protected TeamMatchService $teamMatchService;
    protected StandingService $standingService;

    public function __construct(TeamService $teamService, TeamMatchService $teamMatchService, StandingService $standingService)
    {
        $this->teamService = $teamService;
        $this->teamMatchService = $teamMatchService;
        $this->standingService = $standingService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $teams = $this->teamService->getTeams();

        $teamMatchesOrderedByWeek = $this->teamMatchService->getTeamMatchesOrderedByWeek();

        $weeks = $teamMatchesOrderedByWeek->groupBy('week');

        $standings = collect($teams)->map(function($team) {
            return [
                'team' => $team->name,
                'P' => 0,
                'W' => 0,
                'D' => 0,
                'L' => 0,
                'GD' => 0,
            ];
        });

        $standings = $this->standingService->calculateSimplePrediction($standings);

        $currentWeek = $this->teamMatchService->getCurrentWeek($teamMatchesOrderedByWeek);

        return Inertia::render('Admin/Simulation/Start', [
            'standings' => $standings,
            'weeks' => $weeks,
            'currentWeek' => $currentWeek,
            'currentWeekMatches' => $weeks[$currentWeek] ?? [],
        ]);
    }
}
