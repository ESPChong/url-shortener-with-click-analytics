<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Url;
use Inertia\Inertia;

class DashboardController extends Controller
{
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
