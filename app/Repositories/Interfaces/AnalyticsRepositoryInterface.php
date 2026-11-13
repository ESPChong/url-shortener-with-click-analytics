<?php

namespace App\Repositories\Interfaces;

use App\Models\Url;

interface AnalyticsRepositoryInterface
{
    /**
     * Aggregated click analytics for the given short URL.
     *
     * @return array{short_code: string, total_clicks: int, unique_clicks: int, top_referrers: array<int, array{source: string, count: int}>, geographic_data: array<int, array{country: string, clicks: int}>, daily_clicks: array<int, array{date: string, clicks: int}>}
     */
    public function summary(Url $url): array;
}
