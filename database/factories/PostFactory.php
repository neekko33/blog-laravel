<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date_time = $this->faker->dateTimeBetween('-2 years', 'now');
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'user_id' => 1,
            'category_id' => $this->faker->numberBetween(1, 5),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}
