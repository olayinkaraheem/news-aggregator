<?php

use App\Actions\CreateOtpAction;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Actions\SendEmailVerificationOtpAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\EmailVerificationOtpNotification;

uses(RefreshDatabase::class);

test('SendEmailVerificationOtpAction class works as expected', function () {
    Notification::fake();
    $user = User::factory()->create();

    (new CreateOtpAction)->handle(['user' => $user]);

    $otp = Otp::where('user_id', $user->id)->first();

    $result = (new SendEmailVerificationOtpAction())->handle(['user' => $user, 'otp' => $otp]);

    $this->assertTrue($result);
    Notification::assertSentTo([$user], EmailVerificationOtpNotification::class);
})->group('actions');