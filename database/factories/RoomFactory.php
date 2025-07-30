<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Room ' . $this->faker->unique()->bothify('?-###'),
            'type' => $this->faker->randomElement(['boarding', 'medical', 'luxury']),
            'capacity' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['available', 'occupied']),
        ];
    }
}
