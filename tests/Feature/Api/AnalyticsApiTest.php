<?php

use App\Models\Click;
use App\Models\Url;
use App\Models\User;

test('guests cannot view analytics via the api', function () {
    $this->getJson('/api/analytics/abc123')->assertUnauthorized();
});

test('analytics aggregate clicks, referrers, geography and daily activity', function () {
    $user = User::factory()->create();

    $url = Url::create([
        'long_url' => 'https://example.com/long',
        'short_url' => 'abc123',
    ]);

    $click = fn (array $attributes) => Click::create(array_merge([
        'url_id' => $url->id,
        'redirect_time_ms' => 5.0,
    ], $attributes));

    $click(['ip_hash' => 'visitor-a', 'referrer' => 'google.com', 'country' => 'US']);
    $click(['ip_hash' => 'visitor-a', 'referrer' => 'google.com', 'country' => 'US']);
    $click(['ip_hash' => 'visitor-b', 'referrer' => null, 'country' => 'GB']);

    $this->actingAs($user, 'sanctum')
        ->getJson(route('api.analytics.show', 'abc123'))
        ->assertOk()
        ->assertJsonPath('short_code', 'abc123')
        ->assertJsonPath('total_clicks', 3)
        ->assertJsonPath('unique_clicks', 2)
        ->assertJsonPath('top_referrers.0.source', 'google.com')
        ->assertJsonPath('top_referrers.0.count', 2)
        ->assertJsonPath('top_referrers.1.source', 'direct')
        ->assertJsonPath('geographic_data.0.country', 'US')
        ->assertJsonPath('geographic_data.0.clicks', 2)
        ->assertJsonCount(1, 'daily_clicks')
        ->assertJsonPath('daily_clicks.0.clicks', 3);
});

test('unknown short codes return a 404', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->getJson('/api/analytics/missing')
        ->assertNotFound();
});
