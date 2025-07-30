<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;
use App\Models\Role;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer users (role_id = 3)
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $customers = User::where('role_id', $customerRoleId)->get();

        // Assign 2-3 addresses to each customer
        foreach ($customers as $customer) {
            Address::factory()->count(rand(2, 3))->create([
                'user_id' => $customer->id,
            ]);
        }
    }
}
