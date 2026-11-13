<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Base62;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ShortenUrlRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ShortenController extends Controller
{
    #[OA\Post(
        path: '/shorten',
        summary: 'Create a short URL',
        description: 'Creates a short URL for the given long URL. Optionally accepts a custom alias.',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['url'],
                properties: [
                    new OA\Property(property: 'url', type: 'string', format: 'url', example: 'https://example.com/very/long/url'),
                    new OA\Property(property: 'custom_alias', type: 'string', example: 'mylink', description: 'Optional custom alias (3-32 chars, letters, numbers, dashes)'),
                ]
            )
        ),
        tags: ['URL Shortening'],
        responses: [
            new OA\Response(response: 201, description: 'Short URL created', content: new OA\JsonContent(ref: '#/components/schemas/Url')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(ShortenUrlRequest $request): JsonResponse
    {
        $alias = $request->validated('custom_alias');

        $shortUrl = is_string($alias) ? $alias : Base62::generateShortUrl();

        // Ensure uniqueness to prevent collision
        while (Url::where('short_url', $shortUrl)->exists()) {
            $shortUrl = Base62::generateShortUrl();
        }

        $url = Url::create([
            'long_url' => $request->validated('url'),
            'short_url' => $shortUrl,
        ]);

        return (new UrlResource($url))
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
