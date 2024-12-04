<?php

use App\Models\Otp;
use App\Helpers\Model\OtpHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
uses(WithFaker::class);

test("if exist method works correctly", function () {
    $this->assertFalse(
        (new OtpHelper)
            ->handle(null)
            ->exist()
    );

    $this->assertTrue(
        (new OtpHelper)
            ->handle(Otp::factory()->create())
            ->exist()
    );
})->group('otp-helper');

test("if isExpired method works correctly", function () {
    $this->assertFalse(
        (new OtpHelper)
            ->handle(Otp::factory()->create())
            ->isExpired()
    );

    $this->assertTrue(
        (new OtpHelper)
            ->handle(Otp::factory()->create([
                'expired_at' => now()->subHour()
            ]))
            ->isExpired()
    );
})->group('otp-helper');

test("if isValid method works correctly", function () {
    $plainCode = $this->faker->unique()->numberBetween(1000000, 9999999);

    $hashedCode = Hash::make($plainCode);

    $otp = Otp::factory()->create([
        'code' => $hashedCode
    ]);

    $this->assertFalse(
        (new OtpHelper)
            ->handle($otp)
            ->isValid($this->faker->unique()->numberBetween(1000000, 9999999))
    );

    $this->assertTrue(
        (new OtpHelper)
            ->handle($otp)
            ->isValid($plainCode)
    );
})->group('otp-helper');

test("if generateCode method works correctly", function () {
    $code = (new OtpHelper)->generateCode();

    $this->assertTrue(Hash::check($code['plain_text'], $code['hashed']));
})->group('otp-helper');