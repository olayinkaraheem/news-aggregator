<?php

namespace App\Helpers\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class OtpHelper
{
    private ?Model $otp;

    public function handle(?Model $otp): self
    {
        $this->otp = $otp;

        return $this;
    }

    public function exist(): bool
    {
        return (bool)$this->otp;
    }

    public function isExpired(): bool
    {
        return $this->otp->expired_at->lessThanOrEqualTo(now());
    }

    public function isValid(string $value): bool
    {
        return Hash::check($value, $this->otp->code);
    }

    public function generateCode(): array
    {
        return [
            'plain_text'    => $code = rand(100000, 999999),
            'hashed'        => Hash::make($code)
        ];
    }

    public function getExpiredAt(): Carbon
    {
        return now()->addMinutes(
            (int) config('otp.expired_in_the_next_minutes')
        );
    }
}