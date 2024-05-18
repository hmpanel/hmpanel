<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TechVersion;
use Illuminate\Auth\Access\HandlesAuthorization;

class TechVersionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the techVersion can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list techversions');
    }

    /**
     * Determine whether the techVersion can view the model.
     */
    public function view(User $user, TechVersion $model): bool
    {
        return $user->hasPermissionTo('view techversions');
    }

    /**
     * Determine whether the techVersion can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create techversions');
    }

    /**
     * Determine whether the techVersion can update the model.
     */
    public function update(User $user, TechVersion $model): bool
    {
        return $user->hasPermissionTo('update techversions');
    }

    /**
     * Determine whether the techVersion can delete the model.
     */
    public function delete(User $user, TechVersion $model): bool
    {
        return $user->hasPermissionTo('delete techversions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete techversions');
    }

    /**
     * Determine whether the techVersion can restore the model.
     */
    public function restore(User $user, TechVersion $model): bool
    {
        return false;
    }

    /**
     * Determine whether the techVersion can permanently delete the model.
     */
    public function forceDelete(User $user, TechVersion $model): bool
    {
        return false;
    }
}
