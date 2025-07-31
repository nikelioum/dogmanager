<?php

namespace App\Policies;

use App\Models\Address; // Assuming you have an Address model
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    /**
     * Determine whether the user can view any models (e.g., list all addresses).
     * Only users with role_id 1 can view any addresses.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can view the model (e.g., view a specific address).
     * Only users with role_id 1 can view a specific address.
     */
    public function view(User $user, Address $address): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can create models (e.g., create a new address).
     * Only users with role_id 1 can create new addresses.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model (e.g., update an address's details).
     * Only users with role_id 1 can update addresses.
     */
    public function update(User $user, Address $address): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model (e.g., delete an address).
     * Only users with role_id 1 can delete addresses.
     */
    public function delete(User $user, Address $address): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     * This is typically for soft-deleted models. Only users with role_id 1 can restore addresses.
     */
    public function restore(User $user, Address $address): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only users with role_id 1 can force delete addresses.
     */
    public function forceDelete(User $user, Address $address): bool
    {
        return $user->role_id === 1;
    }
}
