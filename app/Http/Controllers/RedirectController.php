<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Click;

class RedirectController extends Controller
{
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
