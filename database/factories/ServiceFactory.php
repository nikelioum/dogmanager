<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            [
                'name' => 'Dog Walking',
                'description' => 'Daily walks for your dog.',
                'time_in_minutes' => 45,
                'price' => 10.00,
            ],
            [
                'name' => 'Pet Sitting',
                'description' => 'In-home or facility-based pet sitting.',
                'time_in_minutes' => 60,
                'price' => 25.00,
            ],
            [
                'name' => 'Grooming',
                'description' => 'Bathing and grooming services.',
                'time_in_minutes' => 90,
                'price' => 40.00,
            ],
            [
                'name' => 'Training',
                'description' => 'Basic obedience training for pets.',
                'time_in_minutes' => 60,
                'price' => 50.00,
            ],
            [
                'name' => 'Veterinary Checkup',
                'description' => 'Routine health checkup for pets.',
                'time_in_minutes' => 30,
                'price' => 60.00,
            ],
        ];

        $service = $this->faker->unique()->randomElement($services);

        return [
            'name' => $service['name'],
            'description' => $service['description'],
            'time_in_minutes' => $service['time_in_minutes'],
            'price' => $service['price'],
        ];
    }
}
