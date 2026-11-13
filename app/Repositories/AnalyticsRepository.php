<?php

namespace App\Repositories;

use App\Models\Click;
use App\Models\Url;
use App\Repositories\Interfaces\AnalyticsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AnalyticsRepository implements AnalyticsRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function summary(Url $url): array
    {
        $clicks = Click::query()->where('url_id', $url->id);

        $referrers = (clone $clicks)
            ->select('referrer', DB::raw('COUNT(*) as count'))
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(fn (Click $row) => [
                'source' => $row->referrer ?? 'direct',
                'count' => (int) $row->getAttribute('count'),
            ]);

        $geography = (clone $clicks)
            ->whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as clicks'))
            ->groupBy('country')
            ->orderByDesc('clicks')
            ->limit(5)
            ->get()
            ->map(fn (Click $row) => [
                'country' => (string) $row->country,
                'clicks' => (int) $row->getAttribute('clicks'),
            ]);

        $daily = (clone $clicks)
            ->whereBetween('created_at', [now()->subDays(29)->startOfDay(), now()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as clicks')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn (Click $row) => [
                'date' => (string) $row->getAttribute('date'),
                'clicks' => (int) $row->getAttribute('clicks'),
            ]);

        return [
            'short_code' => $url->short_url,
            'total_clicks' => (clone $clicks)->count(),
            'unique_clicks' => (clone $clicks)->distinct()->count('ip_hash'),
            'top_referrers' => $referrers->all(),
            'geographic_data' => $geography->all(),
            'daily_clicks' => $daily->all(),
        ];
    }
}
