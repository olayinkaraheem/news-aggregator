<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\NewsAggregate;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPreference>
 */
class UserPreferenceFactory extends Factory
{
    protected $model = UserPreference::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $news_aggregates = NewsAggregate::factory(5)->create();

        return  [
            'user_id' => $user->id,
            'sources' => $news_aggregates->pluck('source')->take(rand(1, 3)),
            'authors' => $news_aggregates->pluck('author')->take(rand(1, 3)),
            'categories' => $news_aggregates->pluck('category')->take(rand(1, 3))
        ];
    }
    

    
}
