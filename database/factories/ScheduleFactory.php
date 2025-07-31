<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Pet;
use App\Models\Address;
use App\Models\Service;
use App\Models\Role;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $employeeRoleId = Role::where('name', 'employee')->first()->id ?? 2;
        $pet = Pet::whereHas('user', fn($query) => $query->where('role_id', $customerRoleId))->inRandomOrder()->first();
        $weekStart = Carbon::today()->startOfWeek();

        return [
            'employee_id' => User::where('role_id', $employeeRoleId)->inRandomOrder()->first()->id ?? null,
            'pet_id' => $pet ? $pet->id : null,
            'address_id' => $pet ? Address::where('user_id', $pet->user_id)->inRandomOrder()->first()->id : null,
            'service_id' => Service::where('name', 'Dog Walking')->first()->id ?? Service::inRandomOrder()->first()->id,
            'scheduled_at' => $weekStart->copy()->addDays(rand(0, 6))->addHours(rand(8, 17)),
            'week_start_date' => $weekStart,
        ];
    }
}
