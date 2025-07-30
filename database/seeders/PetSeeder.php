<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer users (role_id = 3)
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $customers = User::where('role_id', $customerRoleId)->get();

        // Assign 1-3 pets to each customer, linked to one of their addresses
        foreach ($customers as $customer) {
            $addresses = Address::where('user_id', $customer->id)->get();
            if ($addresses->isEmpty()) {
                continue; // Skip if customer has no addresses
            }
            $petCount = rand(1, 3);
            for ($i = 0; $i < $petCount; $i++) {
                Pet::factory()->create([
                    'user_id' => $customer->id,
                    'address_id' => $addresses->random()->id,
                ]);
            }
        }
    }
}
