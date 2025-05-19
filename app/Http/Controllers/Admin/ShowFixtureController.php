<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TeamMatch;
use App\Services\TeamMatchService;
use App\Http\Controllers\Controller;

class ShowFixtureController extends Controller
{
    protected TeamMatchService $teamMatchService;

    public function __construct(TeamMatchService $teamMatchService)
    {
        $this->teamMatchService = $teamMatchService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $matchesOrderByWeek = $this->teamMatchService->getTeamMatchesOrderedByWeek();

        $weeks = $matchesOrderByWeek->groupBy('week');

        $allPlayed = smartCache()->getJson(TeamMatch::ALL_PLAYED_CACHE_KEY);

        return Inertia::render('Admin/Fixture/Show', [
            'weeks' => $weeks,
            'allPlayed' => $allPlayed,
        ]);
    }
}
