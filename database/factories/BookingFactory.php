<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;
use App\Models\Room;
use App\Models\Role;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $pet = Pet::whereHas('user', fn($query) => $query->where('role_id', $customerRoleId))->inRandomOrder()->first();
        $startDate = Carbon::today()->addDays($this->faker->numberBetween(-5, 5));

        return [
            'pet_id' => $pet ? $pet->id : null,
            'room_id' => Room::where('status', 'available')->inRandomOrder()->first()->id ?? null,
            'start_date' => $startDate,
            'end_date' => $startDate->copy()->addDays($this->faker->numberBetween(1, 7)),
        ];
    }
}
