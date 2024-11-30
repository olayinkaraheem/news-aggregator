<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Helpers\Http\NewsAggregatorResponse;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\PasswordResetOtpRequest;
use App\Http\Requests\Auth\SendEmailVerificationOtpRequest;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}

    public function signup(SignUpRequest $request): JsonResponse
    {
        $this->authService->signUp($request->validated());

        return (new NewsAggregatorResponse(
            message: __('general.successful', ['action' => 'Sign-Up'])
        ))->asSuccessful();
    }

    public function sendEmailVerificationOtp(SendEmailVerificationOtpRequest $request): JsonResponse
    {
        $this->authService->sendEmailVerificationOtp($request->validated());

        return (new NewsAggregatorResponse(
            message: __('auth.email_verification_otp_request_successful')
        ))->asSuccessful();
    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        $data = $this->authService->verifyEmail($request->validated());

        return (new NewsAggregatorResponse(
            data: $data,
            message: __('general.successful', ['action' => 'Email verification'])
        ))->asSuccessful();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        return (new NewsAggregatorResponse(
            data: $data,
            message: __('general.successful', ['action' => 'Login'])
        ))->asSuccessful();
    }
    public function logout(Request $request): JsonResponse
    {
        $data = $this->authService->logout($request->user());

        return (new NewsAggregatorResponse(
            message: __('general.successful', ['action' => 'Logout'])
        ))->asSuccessful();
    }

    public function requestPasswordReset(PasswordResetOtpRequest $request): JsonResponse
    {
        $this->authService->sendPasswordResetOtp($request->validated());

        return (new NewsAggregatorResponse(
            message: __('auth.password_reset_request_successful')
        ))->asSuccessful();
    }

    public function resetPassword(PasswordResetRequest $request): JsonResponse
    {
        $this->authService->resetPassword($request->validated());

        return (new NewsAggregatorResponse(
            message: __('auth.password_reset_successful')
        ))->asSuccessful();
    }
}