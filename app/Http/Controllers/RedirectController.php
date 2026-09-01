<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Click;

use OpenApi\Attributes as OA;

class RedirectController extends Controller
{
    #[OA\Get(
        path: '/r/{shortUrl}',
        summary: 'Redirect to Long URL',
        description: 'Accepts Short URL and Redirects to Long URL. Tracks the click and records analytics data like redirect time.',
        tags: ['URL Redirection'],
        parameters: [
            new OA\Parameter(
                name: 'shortUrl',
                in: 'path',
                description: 'The unique short URL code to redirect',
                schema: new OA\Schema(type: 'string', example: 'abc123')
            )
        ],
        responses: [
            new OA\Response(
                name: '302',
                description: 'Successful redirect to the long URL',
                headers: [
                    new OA\Header(
                        header: 'Location',
                        description: 'The original URL to redirect to',
                        schema: new OA\Schema(type: 'string', format: 'url')
                    )
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Short URL not found'
            )
        ]
    )]
    public function show($shortUrl)
    {
        $startTime = microtime(true);

        $urlRecord = Url::where('short_url', $shortUrl)->firstOrFail();
        $urlRecord->increment('click_count');

        $endTime = microtime(true);
        $redirectTimeMs = round(($endTime - $startTime) * 1000);

        Click::create([
            'url_id' => $urlRecord->id,
            'redirect_time_ms' => $redirectTimeMs,
        ]);

        return redirect()->away($urlRecord->long_url);
    }
}
