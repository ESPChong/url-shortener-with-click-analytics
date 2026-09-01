<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Url;
use Inertia\Inertia;

use OpenApi\Attributes as OA;

class DashboardController extends Controller
{
    #[OA\Get(
        path: '/dash',
        summary: 'Display Dashboard Page',
        description: 'Renders the Inertia.js dashboard page for displaying click analytics.',
        tags: ['UI Pages'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Inertia page rendered successfully.'
            )
        ]
    )]
    public function index()
    {
        $totalShortens = Url::count();
        $shortensToday = Url::whereDate('created_at', today())->count();

        $totalClicks = Click::count();
        $clicksToday = Click::whereDate('created_at', today())->count();

        $avgRedTime = Click::avg('redirect_time_ms');

        return Inertia::render('dash', [
            'stats' => [
                'total_shortens' => $totalShortens,
                'shortens_today' => $shortensToday,
                'total_clicks' => $totalClicks,
                'clicks_today' => $clicksToday,
                'avg_red_time' => round($avgRedTime, 2),
            ]
        ]);
    }
}
