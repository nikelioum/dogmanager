<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create 1 admin user
        User::factory()->withRole('admin')->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create 3 employee users
        User::factory()->count(3)->withRole('employee')->create();

        // Create 3 customer users
        User::factory()->count(3)->withRole('customer')->create();
    }
}
