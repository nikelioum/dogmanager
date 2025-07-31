<?php

namespace App\Policies;

use App\Models\Booking; // Assuming you have a Booking model
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models (e.g., list all bookings).
     * Only users with role_id 1 can view any bookings.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can view the model (e.g., view a specific booking).
     * Only users with role_id 1 can view a specific booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can create models (e.g., create a new booking).
     * Only users with role_id 1 can create new bookings.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model (e.g., update a booking's details).
     * Only users with role_id 1 can update bookings.
     */
    public function update(User $user, Booking $booking): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model (e.g., delete a booking).
     * Only users with role_id 1 can delete bookings.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     * This is typically for soft-deleted models. Only users with role_id 1 can restore bookings.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only users with role_id 1 can force delete bookings.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->role_id === 1;
    }
}
