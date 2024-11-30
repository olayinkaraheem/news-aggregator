<?php

namespace App\Services;

use App\Models\User;
use App\Actions\CreateOtpAction;
use App\Actions\CreateUserAction;
use App\Processors\UserProcessor;
use Illuminate\Pipeline\Pipeline;
use App\Actions\VerifyEmailAction;
use App\Actions\ResetPasswordAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\GeneralUserException;
use App\Actions\SendPasswordResetOtpAction;
use App\Exceptions\EntityNotFoundException;
use App\Actions\SendEmailVerificationOtpAction;
use App\Actions\SendWelcomeUserNotificationAction;

class AuthService
{

    public function signUp(array $request_data): void
    {
        app(Pipeline::class)
            ->send([
                'email' => $request_data['email'],
                'name' => $request_data['name'],
                'password' => $request_data['password'],
            ])
            ->through([
                CreateUserAction::class,
                SendWelcomeUserNotificationAction::class,
                CreateOtpAction::class,
                SendEmailVerificationOtpAction::class,
            ])
            ->thenReturn();
    }

    public function login(array $request_data): array
    {
        $existingUser = User::whereEmail($request_data['email'])->first();

        throw_if(!$existingUser, (new GeneralUserException(__('auth.failed'))));

        throw_if(!Hash::check($request_data['password'], $existingUser->password), (new GeneralUserException(__('auth.failed'))));

        $token = $this->authenticate($existingUser);

        return [
            'token' => $token,
            'user' => (new UserProcessor)->extractFormat($existingUser)
        ];
    }

    /**
     * Singout the current authenticated user
     * @param   User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    public function sendEmailVerificationOtp(array $request_data)
    {
        $user = User::whereEmail($request_data['email'])->first();

        $this->CheckOtpRequestCount($user);

        throw_if(!$user, (new EntityNotFoundException(__('general.not_found', ['entity' => 'User']))));

        if ($user) {
            app(Pipeline::class)
                ->send(['user'  => $user])
                ->through([
                    CreateOtpAction::class,
                    SendEmailVerificationOtpAction::class
                ])
                ->thenReturn();
        }
    }

    public function verifyEmail(array $request_data)
    {
        $user = User::whereEmail($request_data['email'])->first();

        if (!$user) {
            return [];
        }

        $user->otps()->delete();

        ['user' => $user] = app(Pipeline::class)
            ->send(['user'  => $user])
            ->through([
                VerifyEmailAction::class,
            ])
            ->thenReturn();

        return (new UserProcessor)->extractFormat($user->refresh());
    }

    public function sendPasswordResetOtp(array $request_data)
    {
        $user = User::whereEmail($request_data['email'])->first();

        if (!$user) {
            return [];
        }

        $this->checkOtpRequestCount($user);

        app(Pipeline::class)
            ->send(['user'  => $user])
            ->through([
                CreateOtpAction::class,
                SendPasswordResetOtpAction::class
            ])
            ->thenReturn();
    }

    public function resetPassword(array $request_data): void
    {
        $user = User::whereEmail($request_data['email'])->first();

        if (!$user) {
            return;
        }

        $user->otps()->delete();

        app(Pipeline::class)
            ->send([
                'user'  => $user,
                'password' => $request_data['password']
            ])
            ->through([
                ResetPasswordAction::class
            ])
            ->thenReturn();
    }

    protected function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    protected function authenticate(User $user): string
    {
        Auth::login($user);

        throw_if(!auth()->user(), (new GeneralUserException(__('auth.failed'))));

        return auth()->user()->createToken('login_token')->plainTextToken;
    }

    protected function checkOtpRequestCount(User $user): void
    {
        if ($user->otps->count() >= config('otp.max_send_count')) {
            throw new GeneralUserException(
                __('auth.otp_max_send_exceeded', ['count' => config('otp.max_send_count')])
            );
        }
    }
}
