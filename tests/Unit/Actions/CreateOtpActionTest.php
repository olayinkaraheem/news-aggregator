<?php

use App\Models\User;
use App\Actions\CreateOtpAction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('CreateOtpAction class works as expected', function () {
    $user = User::factory()->create();
    
    $result = (new CreateOtpAction())->handle(['user' => $user]);

    $this->assertTrue($result);
    $this->assertDatabaseHas('otps', [
        'user_id' => $user->id
    ]);
})->group('actions');