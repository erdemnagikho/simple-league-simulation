<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TeamMatch;
use App\Services\TeamService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        smartCache()->setJson(TeamMatch::ALL_PLAYED_CACHE_KEY, false);

        return Inertia::render('Admin/Dashboard', [
            'teams' => $this->teamService->getTeams(),
        ]);
    }
}
