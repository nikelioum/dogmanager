<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models (e.g., list all roles).
     * Only users with role_id 1 can view any roles.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can view the model (e.g., view a specific role).
     * Only users with role_id 1 can view a specific role.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can create models (e.g., create a new role).
     * Only users with role_id 1 can create new roles.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model (e.g., update a role's details).
     * Only users with role_id 1 can update roles.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model (e.g., delete a role).
     * Only users with role_id 1 can delete roles.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     * This is typically for soft-deleted models. Only users with role_id 1 can restore roles.
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only users with role_id 1 can force delete roles.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $user->role_id === 1;
    }
}
