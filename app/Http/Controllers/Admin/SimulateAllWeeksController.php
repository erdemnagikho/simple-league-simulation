<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TeamMatch;
use App\Services\TeamService;
use App\Services\SimulateService;
use App\Services\StandingService;
use App\Services\TeamMatchService;
use App\Http\Controllers\Controller;

class SimulateAllWeeksController extends Controller
{
    protected TeamService $teamService;
    protected TeamMatchService $teamMatchService;
    protected SimulateService $simulateService;
    protected StandingService $standingService;

    public function __construct(
        TeamService      $teamService,
        TeamMatchService $teamMatchService,
        SimulateService  $simulateService,
        StandingService  $standingService
    )
    {
        $this->teamService = $teamService;
        $this->teamMatchService = $teamMatchService;
        $this->simulateService = $simulateService;
        $this->standingService = $standingService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $allUnPlayedMatches = $this->teamMatchService->getAllUnPlayedMatchesOrderedByWeek();

        $this->simulateService->simulate($allUnPlayedMatches);

        $teams = $this->teamService->getTeams();

        $matchesOrderedByWeek = $this->teamMatchService->getTeamMatchesOrderedByWeek();

        $weeks = $matchesOrderedByWeek->groupBy('week');

        $standings = $this->standingService->calculateDynamicStanding($teams, $matchesOrderedByWeek);

        $standings = $this->standingService->calculateSimplePrediction($standings);

        $currentWeek = smartCache()->getJson(TeamMatch::TOTAL_WEEKS);

        smartCache()->setJson(TeamMatch::ALL_PLAYED_CACHE_KEY, true);

        return Inertia::render('Admin/Simulation/Start', [
            'standings' => $standings,
            'weeks' => $weeks,
            'currentWeek' => $currentWeek,
            'currentWeekMatches' => $weeks[$currentWeek] ?? [],
            'allPlayed' => true,
        ]);
    }
}
