<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMatch;
use App\Models\MatchResult;
use App\Services\TeamService;
use App\Services\FixtureService;
use App\Services\TeamMatchService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class GenerateFixtureController extends Controller
{
    protected FixtureService $fixtureService;
    protected TeamService $teamService;
    protected TeamMatchService $teamMatchService;

    public function __construct(FixtureService $fixtureService, TeamService $teamService, TeamMatchService $teamMatchService)
    {
        $this->fixtureService = $fixtureService;
        $this->teamService = $teamService;
        $this->teamMatchService = $teamMatchService;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $teams = $this->teamService->getTeams();

        MatchResult::query()->delete();
        TeamMatch::query()->delete();

        $matchWeeks = $this->fixtureService->generateFixture($teams);

        $this->teamMatchService->insertTeamMatches($matchWeeks);

        return redirect()->route('admin.fixtures.show');
    }
}
