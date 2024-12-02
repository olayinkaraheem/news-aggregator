<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeUserNotification;
use App\Actions\SendWelcomeUserNotificationAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('SendWelcomeUserNotificationAction class works as expected', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $result = (new SendWelcomeUserNotificationAction)->handle(['user' => $user]);

    $this->assertTrue($result);
    Notification::assertSentTo([$user], WelcomeUserNotification::class);
})->group('actions');