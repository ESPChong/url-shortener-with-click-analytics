<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Repositories\Interfaces\AnalyticsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsRepositoryInterface $analytics,
    ) {}

    #[OA\Get(
        path: '/analytics/{shortUrl}',
        summary: 'Get click analytics for a short URL',
        description: 'Returns aggregated click analytics: totals, unique visitors, top referrers, geography (last 30 days of daily clicks).',
        security: [['bearerAuth' => []]],
        tags: ['Analytics'],
        parameters: [
            new OA\Parameter(
                name: 'shortUrl',
                in: 'path',
                required: true,
                description: 'The short URL code to fetch analytics for',
                schema: new OA\Schema(type: 'string', example: 'mylink')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Aggregated analytics',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'short_code', type: 'string', example: 'mylink'),
                        new OA\Property(property: 'total_clicks', type: 'integer', example: 1250),
                        new OA\Property(property: 'unique_clicks', type: 'integer', example: 980),
                        new OA\Property(property: 'top_referrers', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'source', type: 'string', example: 'google.com'),
                                new OA\Property(property: 'count', type: 'integer', example: 320),
                            ]
                        )),
                        new OA\Property(property: 'geographic_data', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'country', type: 'string', example: 'US'),
                                new OA\Property(property: 'clicks', type: 'integer', example: 450),
                            ]
                        )),
                        new OA\Property(property: 'daily_clicks', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'date', type: 'string', format: 'date', example: '2026-11-13'),
                                new OA\Property(property: 'clicks', type: 'integer', example: 95),
                            ]
                        )),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Short URL not found'),
        ]
    )]
    public function show(string $shortUrl): JsonResponse
    {
        $url = Url::where('short_url', $shortUrl)->firstOrFail();

        return response()->json($this->analytics->summary($url));
    }
}
