<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Pet;
use App\Models\Address;
use App\Models\Service;
use App\Models\Role;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $employeeRoleId = Role::where('name', 'employee')->first()->id ?? 2;
        $pets = Pet::whereHas('user', fn($query) => $query->where('role_id', $customerRoleId))->get();
        $employees = User::where('role_id', $employeeRoleId)->get();
        $weekStart = Carbon::today()->startOfWeek();

        foreach ($pets as $pet) {
            $address = Address::where('user_id', $pet->user_id)->inRandomOrder()->first();
            if (!$address) {
                continue;
            }
            $scheduleCount = rand(1, 3);
            for ($i = 0; $i < $scheduleCount; $i++) {
                Schedule::factory()->create([
                    'employee_id' => $employees->random()->id,
                    'pet_id' => $pet->id,
                    'address_id' => $address->id,
                    'service_id' => Service::where('name', 'Dog Walking')->first()->id ?? Service::inRandomOrder()->first()->id,
                    'scheduled_at' => $weekStart->copy()->addDays(rand(0, 6))->addHours(rand(8, 17)),
                    'week_start_date' => $weekStart,
                ]);
            }
        }
    }
}
