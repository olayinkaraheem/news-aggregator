<?php

namespace Database\Factories;

use App\Enums\NewsProviderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsAggregate>
 */
class NewsAggregateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image_url' => $this->faker->url,
            'url' => $this->faker->url,
            'content' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->word,
            'author' => $this->faker->name,
            'source' => $this->getRandomNewsSource(),
            'published_date' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
        ];
    }

    protected function getRandomNewsSource()
    {
        return ucwords(str_replace('_', ' ', NewsProviderEnum::valueArray()[rand(0, count(NewsProviderEnum::valueArray()) - 1)]));
    }
}
