<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Auth\Traits\OtpValidationTrait;

class VerifyEmailRequest extends FormRequest
{
    use OtpValidationTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric'
        ];
    }
}
