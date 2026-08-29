<?php

namespace App\Http\Controllers;

use App\Models\Url;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortenController extends Controller {
    public function index()
    {
        return Inertia::render('shorten');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'long_url' => 'required|url',
        ]);

        // random string for shortUrl
        $shortUrl = Str::random(7);

        // create an entry in the url table
        Url::create([
            'long_url' => $validated['long_url'],
            'short_url' => $shortUrl,
        ]);

        return back()->with('shortUrl', $shortUrl);
    }
}
