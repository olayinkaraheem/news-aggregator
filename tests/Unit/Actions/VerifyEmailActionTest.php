<?php

use App\Models\User;
use App\Actions\VerifyEmailAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('VerifyEmailAction works as expected', function () {

    $user = User::factory()->unverified()->create();

    $result = (new VerifyEmailAction)->handle(['user' => $user]);

    $this->assertTrue($result);
    $this->assertNotNull($user->refresh()->email_verified_at);
})->group('actions');