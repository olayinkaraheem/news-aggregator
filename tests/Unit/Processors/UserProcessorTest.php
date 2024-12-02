<?php

use App\Models\User;
use App\Processors\UserProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Verify extractFormat returns the correct data for verified user', function () {
    $user = User::factory()->create();

    $data = (new UserProcessor)->extractFormat($user);

    expect($data)->toBe([
        'name' => $user->name,
        'email' => $user->email,
        'email_verified' => true,
    ]);
})->group('processors');

test('Verify extractFormat returns the correct data for unverified user', function () {
    $user = User::factory()->unverified()->create();

    $data = (new UserProcessor)->extractFormat($user);

    expect($data)->toBe([
        'name' => $user->name,
        'email' => $user->email,
        'email_verified' => false,
    ]);
})->group('processors');
