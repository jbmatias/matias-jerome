<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weekday>
 */
class WeekdayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->dayOfWeek,
            'value' => $this->faker->numberBetween(0, 6),
            'enabled' => $this->faker->boolean,
        ];
    }
}
