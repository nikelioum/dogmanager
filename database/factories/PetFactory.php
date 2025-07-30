<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $customer = User::where('role_id', $customerRoleId)->inRandomOrder()->first();

        return [
            'user_id' => $customer ? $customer->id : null,
            'address_id' => $customer ? Address::where('user_id', $customer->id)->inRandomOrder()->first()->id : null,
            'name' => $this->faker->firstName,
            'species' => $this->faker->randomElement(['Dog']),
            'breed' => $this->faker->optional()->word,
        ];
    }
}
