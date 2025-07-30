<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Role;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer pets
        $customerRoleId = Role::where('name', 'customer')->first()->id ?? 3;
        $pets = Pet::whereHas('user', fn($query) => $query->where('role_id', $customerRoleId))->get();

        foreach ($pets as $pet) {
            // Skip if no available rooms
            $availableRoom = Room::where('status', 'available')->inRandomOrder()->first();
            if (!$availableRoom) {
                continue;
            }

            // Create 1-2 bookings per pet
            $bookingCount = rand(1, 2);
            for ($i = 0; $i < $bookingCount; $i++) {
                $startDate = Carbon::today()->addDays(rand(-5, 5));
                $endDate = $startDate->copy()->addDays(rand(1, 7));

                // Ensure no overlapping bookings for the room
                $hasOverlap = Booking::where('room_id', $availableRoom->id)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('start_date', [$startDate, $endDate])
                              ->orWhereBetween('end_date', [$startDate, $endDate])
                              ->orWhereRaw('? BETWEEN start_date AND end_date', [$startDate])
                              ->orWhereRaw('? BETWEEN start_date AND end_date', [$endDate]);
                    })->exists();

                if (!$hasOverlap) {
                    Booking::factory()->create([
                        'pet_id' => $pet->id,
                        'room_id' => $availableRoom->id,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]);
                    // Update room status to occupied if booking is active
                    if ($startDate <= Carbon::today() && $endDate >= Carbon::today()) {
                        $availableRoom->update(['status' => 'occupied']);
                    }
                }

                // Find another available room for the next booking
                $availableRoom = Room::where('status', 'available')->inRandomOrder()->first();
                if (!$availableRoom) {
                    break;
                }
            }
        }
    }
}
