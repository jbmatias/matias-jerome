<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeekdayStoreHour>
 */
class WeekdayStoreHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'open' => $this->faker->time('H:i'),
            'close' => $this->faker->time('H:i'),
            'break_time_start' => $this->faker->time('H:i'),
            'break_time_end' => $this->faker->time('H:i'),
            'every_other_week' => $this->faker->boolean(),
        ];
    }
}
