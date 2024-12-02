<?php

use App\Models\Otp;
use App\Models\User;
use App\Actions\CreateOtpAction;
use App\Actions\SendPasswordResetOtpAction;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\SendPasswordResetOtpNotification;

// 
uses(RefreshDatabase::class);

test('SendPasswordResetOtpAction class works as expected', function () {
    Notification::fake();
    $user = User::factory()->create();

    (new CreateOtpAction)->handle(['user' => $user]);

    $otp = Otp::where('user_id', $user->id)->first();

    $result = (new SendPasswordResetOtpAction)->handle(['user' => $user, 'otp' => $otp]);

    $this->assertTrue($result);
    Notification::assertSentTo([$user], SendPasswordResetOtpNotification::class);
})->group('actions');