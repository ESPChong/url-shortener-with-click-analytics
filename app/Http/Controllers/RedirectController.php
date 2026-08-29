<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Click;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function show($shortUrl)
    {
        $urlRecord = Url::where('short_url', $shortUrl)->firstOrFail();
        $urlRecord->increment('click_count');
        $urlRecord->refresh();  // refresh to prevent state errors

        Click::create([
            'url_id' => $urlRecord->id,
        ]);

        return redirect()->away($urlRecord->long_url);
    }
}
