<?php

namespace App\Http\Controllers;

use App\Models\Url;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function show($shortUrl)
    {
        $urlRecord = Url::where('short_url', $shortUrl)->firstOrFail();
        return redirect()->away($urlRecord->long_url);
    }
}
