<?php

namespace App\Http\Controllers;

use App\Helpers\GeoIp;
use App\Models\Click;
use App\Models\Url;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class RedirectController extends Controller
{
    #[OA\Get(
        path: '/r/{shortUrl}',
        summary: 'Redirect to Long url',
        description: 'Accepts a short url and redirects to the long url. Every hit is tracked: redirect latency, a hashed visitor IP (for unique-click counts), the referring host and the visitor country.',
        tags: ['URL Redirection'],
        parameters: [
            new OA\Parameter(
                name: 'shortUrl',
                in: 'path',
                description: 'The unique short url code to redirect',
                schema: new OA\Schema(type: 'string', example: 'abc123')
            ),
        ],
        responses: [
            new OA\Response(
                response: 302,
                description: 'Successful redirect to the long url',
                headers: [
                    new OA\Header(
                        header: 'Location',
                        description: 'The original url to redirect to',
                        schema: new OA\Schema(type: 'string', format: 'url')
                    ),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Short url not found'
            ),
        ]
    )]
    public function show(Request $request, string $shortUrl)
    {
        $startTime = microtime(true);

        $urlRecord = Url::where('short_url', $shortUrl)->firstOrFail();
        $urlRecord->increment('click_count');

        $endTime = microtime(true);
        $redirectTimeMs = round(($endTime - $startTime) * 1000);

        Click::create([
            'url_id' => $urlRecord->id,
            'redirect_time_ms' => $redirectTimeMs,
            'ip_hash' => hash('sha256', ($request->ip() ?? '').(string) config('app.key')),
            'referrer' => $this->referrerHost($request),
            'country' => GeoIp::country($request),
        ]);

        return redirect()->away($urlRecord->long_url);
    }

    /**
     * Extract the referring host (e.g. "google.com") from the Referer header.
     */
    private function referrerHost(Request $request): ?string
    {
        $referer = $request->header('referer');

        if (! is_string($referer) || $referer === '') {
            return null;
        }

        $host = parse_url($referer, PHP_URL_HOST);

        return is_string($host) ? $host : null;
    }
}
