<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Database;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatabasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the database can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list databases');
    }

    /**
     * Determine whether the database can view the model.
     */
    public function view(User $user, Database $model): bool
    {
        return $user->hasPermissionTo('view databases');
    }

    /**
     * Determine whether the database can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create databases');
    }

    /**
     * Determine whether the database can update the model.
     */
    public function update(User $user, Database $model): bool
    {
        return $user->hasPermissionTo('update databases');
    }

    /**
     * Determine whether the database can delete the model.
     */
    public function delete(User $user, Database $model): bool
    {
        return $user->hasPermissionTo('delete databases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete databases');
    }

    /**
     * Determine whether the database can restore the model.
     */
    public function restore(User $user, Database $model): bool
    {
        return false;
    }

    /**
     * Determine whether the database can permanently delete the model.
     */
    public function forceDelete(User $user, Database $model): bool
    {
        return false;
    }
}
