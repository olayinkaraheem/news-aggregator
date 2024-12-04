<?php

use App\Models\Otp;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Helpers\Model\OtpHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\EmailVerificationOtpNotification;
use App\Notifications\SendPasswordResetOtpNotification;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup that runs before each test, if needed (e.g., registering a user, etc.)
    Notification::fake();
});

test('user can register with valid data', function () {
    Notification::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/v1/auth/signup', $data);

    $response->assertStatus(200);

    $response->assertJson([
        "success" => true,
        "message" => "Sign-Up successful"
    ]);

    $this->assertDatabaseHas('users', [
        'email' => $data['email'],
        'name' => $data['name'],
    ]);

    $user = User::where('email', $data['email'])->first();
    expect(Hash::check($data['password'], $user->password))->toBeTrue();

    Notification::assertSentTo([$user], WelcomeUserNotification::class);
    Notification::assertSentTo([$user], EmailVerificationOtpNotification::class);
})->group('auth');

test('user cannot register with invalid data', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password',
    ];

    $response = $this->postJson('/api/v1/auth/signup', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['password']);
})->group('auth');

test('user cannot register with an already existing email', function () {
    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $data = [
        'name' => 'Jane Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/v1/auth/signup', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
})->group('auth');

test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/v1/auth/login', $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data" => [
                "token",
                "user" => [
                    "name",
                    "email",
                    "email_verified",
                ],
            ],
            "message",
            "error",
            "meta"
        ]);
})->group('auth');

test('user cannot login with wrong credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'password123@',
    ];

    $response = $this->postJson('/api/v1/auth/login', $data);

    $response->assertStatus(400)
        ->assertJsonStructure([
            "success",
            "data",
            "message",
            "error",
            "meta"
        ])
        ->assertJson([
            "success" => false,
            "message" => "These credentials do not match our records."
        ]);
})->group('auth');

test('user can logout of the application', function () {

    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/v1/auth/logout');

    $response->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "message",
            "error",
            "meta"
        ])
        ->assertJson([
            "success" => true,
            "message" => "Logout successful"
        ]);

    $this->assertDatabaseMissing('personal_access_tokens', ['tokenable_id' => $user->id]);
})->group('auth');

test('logged out user cannot access protected route', function () {

    $response = $this->getJson('/api/v1/news');

    $response->assertStatus(401)
        ->assertJson([
            "message" => "Unauthenticated."
        ]);
})->group('auth');

test('user must verify email before accessing protected route', function () {
    $user = User::factory()->unverified()->create();

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/v1/news');

    $response->assertStatus(403)
        ->assertJson([
            "message" => "Email address not verified."
        ]);
})->group('auth');

test('user can request request verification otp', function () {
    Notification::fake();
    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
    ];

    $response = $this->postJson('/api/v1/auth/send-email-verification-otp', $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "message",
            "error",
            "meta"
        ])
        ->assertJson([
            "success" => true,
            "message" => "Email verification OTP request successfull."
        ]);

    $this->assertDatabaseHas('otps', [
        'user_id' => $user->id,
    ]);
    Notification::assertSentTo([$user], EmailVerificationOtpNotification::class);
})->group('auth');

test('user can verify email', function () {
    $user = User::factory()->unverified()->create();

    $this->postJson('/api/v1/auth/send-email-verification-otp', ['email' => $user->email]);

    $otpHelper = new OtpHelper();

    $code = $otpHelper->generateCode();

    Otp::where('user_id', $user->id)->first()->update([
        'code' => $code['hashed']
    ]);

    $response = $this->postJson('/api/v1/auth/verify-email', [
        'email' => $user->email,
        'otp' => $code['plain_text'],
    ]);

    $response->assertStatus(200);
})->group('auth');

test('user cannot verify email with invalid OTP', function () {
    $user = User::factory()->unverified()->create();

    $this->postJson('/api/v1/auth/send-email-verification-otp', ['email' => $user->email]);

    $otpHelper = new OtpHelper();

    $code = $otpHelper->generateCode();

    Otp::where('user_id', $user->id)->first()->update([
        'code' => $code['hashed']
    ]);

    $response = $this->postJson('/api/v1/auth/verify-email', [
        'email' => $user->email,
        'otp' => 123434,
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            "message",
            "errors" => [
                "otp"
            ]
        ])
        ->assertJson([
            "message" => "Invalid OTP"
        ]);
})->group('auth');

test('user can request password reset OTP', function() {
    Notification::fake();
    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
    ];

    $response = $this->postJson('/api/v1/auth/request-password-reset', $data);

    $response->assertStatus(200);

    Notification::assertSentTo([$user], SendPasswordResetOtpNotification::class);
})->group('auth');

test('user can reset password', function () {
    $user = User::factory()->create();

    $this->postJson('/api/v1/auth/request-password-reset', ['email' => $user->email]);

    $otpHelper = new OtpHelper();

    $code = $otpHelper->generateCode();

    Otp::where('user_id', $user->id)->first()->update([
        'code' => $code['hashed']
    ]);

    $reset_response = $this->postJson('/api/v1/auth/reset-password', [
        'email' => $user->email,
        'password' => '$password',
        'password_confirmation' => '$password',
        'otp' => $code['plain_text'],
    ]);

    $reset_response->assertStatus(200)
        ->assertJson([
            "message" => __('auth.password_reset_successful')
        ]);

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => '$password',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            "success" => true,
            "message" => "Login successful",
        ]);
})->group('auth');