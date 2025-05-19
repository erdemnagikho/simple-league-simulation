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
use Illuminate\Http\RedirectResponse;

class SimulateNextWeekController extends Controller
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
     * @return Response|RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $allPlayed = false;

        $totalWeeks = smartCache()->getJson(TeamMatch::TOTAL_WEEKS);

        $week = $this->teamMatchService->getFirstWeekWithoutResult();

        if (!$week) {
            return redirect()->route('admin.fixtures.show');
        }

        if ($week == $totalWeeks) {
            smartCache()->setJson(TeamMatch::ALL_PLAYED_CACHE_KEY, true);

            $allPlayed = true;
        }

        $teamMatchesByWeek = $this->teamMatchService->getTeamMatchesByWeek($week);

        $this->simulateService->simulate($teamMatchesByWeek);

        $teams = $this->teamService->getTeams();

        $matchesOrderedByWeek = $this->teamMatchService->getTeamMatchesOrderedByWeek();

        $weeks = $matchesOrderedByWeek->groupBy('week');

        $standings = $this->standingService->calculateDynamicStanding($teams, $matchesOrderedByWeek);

        $standings = $this->standingService->calculateSimplePrediction($standings);

        $currentWeek = $this->teamMatchService->getCurrentWeek($matchesOrderedByWeek);

        return Inertia::render('Admin/Simulation/Start', [
            'standings' => $standings,
            'weeks' => $weeks,
            'currentWeek' => $currentWeek,
            'currentWeekMatches' => $weeks[$currentWeek] ?? [],
            'allPlayed' => $allPlayed,
        ]);
    }
}
