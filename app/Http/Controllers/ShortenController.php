<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Helpers\Base62;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ShortenController extends Controller {
    public function index(Request $request)
    {
        $shortUrl = $request->session()->get('shortUrl');

        return Inertia::render('shorten', [
            'shortUrl' => $shortUrl,
        ]);
    }

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
