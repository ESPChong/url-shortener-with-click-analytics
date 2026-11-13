<?php

use App\Models\Click;
use App\Models\Url;
use Illuminate\Support\Facades\Http;

test('short urls redirect to their destination', function () {
    $url = Url::create([
        'long_url' => 'https://example.com/destination',
        'short_url' => 'abc123',
    ]);

    $this->get('/r/abc123')->assertRedirect('https://example.com/destination');
});

test('redirects record click analytics', function () {
    Http::fake();

    $url = Url::create([
        'long_url' => 'https://example.com/destination',
        'short_url' => 'abc123',
    ]);

    $this->withHeaders([
        'Referer' => 'https://www.google.com/search?q=url+shortener',
    ])->get('/r/abc123');

    $click = Click::query()->where('url_id', $url->id)->first();

    expect($click)->not->toBeNull()
        ->and($click->referrer)->toBe('www.google.com')
        ->and($click->ip_hash)->toBeString()
        ->and($click->redirect_time_ms)->not->toBeNull();

    expect($url->fresh()->click_count)->toBe(1);
});

test('unknown short urls return a 404', function () {
    $this->get('/r/missing')->assertNotFound();
});
