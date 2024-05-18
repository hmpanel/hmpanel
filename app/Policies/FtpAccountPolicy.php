<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FtpAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class FtpAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ftpAccount can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list ftpaccounts');
    }

    /**
     * Determine whether the ftpAccount can view the model.
     */
    public function view(User $user, FtpAccount $model): bool
    {
        return $user->hasPermissionTo('view ftpaccounts');
    }

    /**
     * Determine whether the ftpAccount can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create ftpaccounts');
    }

    /**
     * Determine whether the ftpAccount can update the model.
     */
    public function update(User $user, FtpAccount $model): bool
    {
        return $user->hasPermissionTo('update ftpaccounts');
    }

    /**
     * Determine whether the ftpAccount can delete the model.
     */
    public function delete(User $user, FtpAccount $model): bool
    {
        return $user->hasPermissionTo('delete ftpaccounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete ftpaccounts');
    }

    /**
     * Determine whether the ftpAccount can restore the model.
     */
    public function restore(User $user, FtpAccount $model): bool
    {
        return false;
    }

    /**
     * Determine whether the ftpAccount can permanently delete the model.
     */
    public function forceDelete(User $user, FtpAccount $model): bool
    {
        return false;
    }
}
