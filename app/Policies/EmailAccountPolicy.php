<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmailAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the emailAccount can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list emailaccounts');
    }

    /**
     * Determine whether the emailAccount can view the model.
     */
    public function view(User $user, EmailAccount $model): bool
    {
        return $user->hasPermissionTo('view emailaccounts');
    }

    /**
     * Determine whether the emailAccount can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create emailaccounts');
    }

    /**
     * Determine whether the emailAccount can update the model.
     */
    public function update(User $user, EmailAccount $model): bool
    {
        return $user->hasPermissionTo('update emailaccounts');
    }

    /**
     * Determine whether the emailAccount can delete the model.
     */
    public function delete(User $user, EmailAccount $model): bool
    {
        return $user->hasPermissionTo('delete emailaccounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete emailaccounts');
    }

    /**
     * Determine whether the emailAccount can restore the model.
     */
    public function restore(User $user, EmailAccount $model): bool
    {
        return false;
    }

    /**
     * Determine whether the emailAccount can permanently delete the model.
     */
    public function forceDelete(User $user, EmailAccount $model): bool
    {
        return false;
    }
}
