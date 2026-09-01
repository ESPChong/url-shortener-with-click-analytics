<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Helpers\Base62;

use Inertia\Inertia;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ShortenController extends Controller
{
    // index

    #[OA\Get(
        path: '/shorten',
        summary: 'Display URL Shortener Page',
        description: 'Renders the Inertia.js frontend page for shortening URLs. Retrieves any previously generated short URL from the session.',
        tags: ['UI Pages'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Inertia page rendered successfully'
            )
        ]
    )]

    public function index(Request $request)
    {
        $shortUrl = $request->session()->get('shortUrl');

        return Inertia::render('shorten', [
            'shortUrl' => $shortUrl,
        ]);
    }

    // store

    #[OA\Post(
        path: '/shorten',
        summary: 'Create a Short URL',
        description: 'Accepts a long URL, generates a unique Base62 short URL, stores it in the database, and redirects back with the result.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['long_url'],
                properties: [
                    new OA\Property(
                        property: 'long_url',
                        type: 'string',
                        format: 'url',
                        description: 'The original long URL to shorten',
                        example: 'https://example.com/very/long/url'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 302,
                description: 'Successfully created. Redirects back to the form with the short URL in session flash data.',
                headers: [
                    new OA\Header(
                        header: 'Location',
                        description: 'Redirects back to the previous page',
                        schema: new OA\Schema(type: 'string')
                    )
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error (e.g., invalid URL format)',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The long url format is invalid.'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            )
        ]
    )]

    public function store(Request $request)
    {
        $validated = $request->validate([
            'long_url' => 'required|url',
        ]);

        // generate short URL
        $shortUrl = Base62::generateShortUrl();

        // Ensure uniqueness to prevent collision
        while (Url::where('short_url', $shortUrl)->exists()) {
            $shortUrl = Base62::generateShortUrl();
        }

        // create an entry in the url table
        Url::create([
            'long_url' => $validated['long_url'],
            'short_url' => $shortUrl,
        ]);

        return back()->with('shortUrl', $shortUrl);
    }
}
