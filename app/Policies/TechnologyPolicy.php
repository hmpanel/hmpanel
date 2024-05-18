<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Technology;
use Illuminate\Auth\Access\HandlesAuthorization;

class TechnologyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the technology can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list technologies');
    }

    /**
     * Determine whether the technology can view the model.
     */
    public function view(User $user, Technology $model): bool
    {
        return $user->hasPermissionTo('view technologies');
    }

    /**
     * Determine whether the technology can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create technologies');
    }

    /**
     * Determine whether the technology can update the model.
     */
    public function update(User $user, Technology $model): bool
    {
        return $user->hasPermissionTo('update technologies');
    }

    /**
     * Determine whether the technology can delete the model.
     */
    public function delete(User $user, Technology $model): bool
    {
        return $user->hasPermissionTo('delete technologies');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete technologies');
    }

    /**
     * Determine whether the technology can restore the model.
     */
    public function restore(User $user, Technology $model): bool
    {
        return false;
    }

    /**
     * Determine whether the technology can permanently delete the model.
     */
    public function forceDelete(User $user, Technology $model): bool
    {
        return false;
    }
}
