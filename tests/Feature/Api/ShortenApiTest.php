<?php

use App\Models\Url;
use App\Models\User;

test('guests cannot shorten urls via the api', function () {
    $this->postJson(route('api.shorten.store'), ['url' => 'https://example.com/long'])
        ->assertUnauthorized();
});

test('token holders can shorten urls via the api', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson(route('api.shorten.store'), ['url' => 'https://example.com/very/long']);

    $response->assertCreated()
        ->assertJsonStructure(['original_url', 'short_url', 'short_code', 'created_at']);

    expect($response->json('short_code'))->toBeString()
        ->and($response->json('short_url'))->toContain('/r/');

    $this->assertDatabaseHas('urls', [
        'long_url' => 'https://example.com/very/long',
        'short_url' => $response->json('short_code'),
    ]);
});

test('custom aliases are honoured and must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.shorten.store'), ['url' => 'https://example.com', 'custom_alias' => 'mylink'])
        ->assertCreated()
        ->assertJsonPath('short_code', 'mylink');

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.shorten.store'), ['url' => 'https://example.com', 'custom_alias' => 'mylink'])
        ->assertInvalid('custom_alias');
});

test('invalid urls are rejected', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.shorten.store'), ['url' => 'not-a-valid-url'])
        ->assertInvalid('url');
});
