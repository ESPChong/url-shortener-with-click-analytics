<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class GeoIp
{
    private const CACHE_TTL_SECONDS = 60 * 60 * 24 * 30;

    public static function country(Request $request): ?string
    {
        // Cloudflare exposes the visitor's country when proxied through it.
        $header = $request->header('CF-IPCountry');

        if ($header !== null && ! in_array($header, ['', 'XX', 'T1'], true)) {
            return $header;
        }

        $ip = $request->ip();

        // Skip private/reserved addresses (local dev, internal networks).
        if ($ip === null || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return null;
        }

        return Cache::remember('geoip:'.$ip, self::CACHE_TTL_SECONDS, function () use ($ip): ?string {
            try {
                $response = Http::timeout(3)
                    ->get('http://ip-api.com/json/'.$ip, ['fields' => 'status,countryCode']);

                $country = $response->ok() && $response->json('status') === 'success'
                    ? $response->json('countryCode')
                    : null;

                return is_string($country) ? $country : null;
            } catch (Throwable) {
                return null;
            }
        });
    }
}
