<?php

namespace Database\Factories;

use App\Models\User;
use App\Helpers\Model\OtpHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'          => Hash::make($this->faker->unique()->numberBetween(1000000, 9999999)),
            'user_id'       => User::factory()->create()->id,
            'expired_at'    => (new OtpHelper())->getExpiredAt()
        ];
    }
}
