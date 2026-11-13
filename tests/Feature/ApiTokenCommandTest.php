<?php

use App\Models\User;

test('api tokens can be issued for existing users', function () {
    $user = User::factory()->create(['email' => 'dev@example.com']);

    $this->artisan('api-token:create', ['email' => 'dev@example.com'])
        ->expectsOutputToContain('Personal access token created')
        ->assertExitCode(0);

    expect($user->tokens()->count())->toBe(1);
});

test('api tokens cannot be issued for unknown users', function () {
    $this->artisan('api-token:create', ['email' => 'ghost@example.com'])
        ->assertExitCode(1);
});
