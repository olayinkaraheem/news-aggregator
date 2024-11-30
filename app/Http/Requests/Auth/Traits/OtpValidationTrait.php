<?php
namespace App\Http\Requests\Auth\Traits;

use App\Models\Otp;
use App\Helpers\Model\OtpHelper;
use Illuminate\Pipeline\Pipeline;
use App\Validation\ValidateOtpExists;
use App\Validation\ValidateOtpIsValid;
use App\Validation\ValidateOtpIsNotExpired;

trait OtpValidationTrait
{
    public function withValidator($validator)
    {
        if ($validator->errors()->count()) {
            return;
        }

        $validator->after(function ($validator) {
            $otp = (new OtpHelper())->handle(
                Otp::whereHas('user', fn($q) => $q->whereEmail($this->email))->latest()->first()
            );

            app(Pipeline::class)
                    ->send([
                        'validator' => $validator,
                        'otp' => $otp,
                        'code' => $this->otp
                    ])
                    ->through([
                        ValidateOtpExists::class,
                        ValidateOtpIsValid::class,
                        ValidateOtpIsNotExpired::class,
                    ])
                    ->thenReturn();
        });
    }
}