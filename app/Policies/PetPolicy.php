<?php

namespace App\Policies;

use App\Models\Pet; // Assuming you have a Pet model
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    /**
     * Determine whether the user can view any models (e.g., list all pets).
     * Only users with role_id 1 can view any pets.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can view the model (e.g., view a specific pet).
     * Only users with role_id 1 can view a specific pet.
     */
    public function view(User $user, Pet $pet): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can create models (e.g., create a new pet).
     * Only users with role_id 1 can create new pets.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model (e.g., update a pet's details).
     * Only users with role_id 1 can update pets.
     */
    public function update(User $user, Pet $pet): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model (e.g., delete a pet).
     * Only users with role_id 1 can delete pets.
     */
    public function delete(User $user, Pet $pet): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     * This is typically for soft-deleted models. Only users with role_id 1 can restore pets.
     */
    public function restore(User $user, Pet $pet): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only users with role_id 1 can force delete pets.
     */
    public function forceDelete(User $user, Pet $pet): bool
    {
        return $user->role_id === 1;
    }
}
