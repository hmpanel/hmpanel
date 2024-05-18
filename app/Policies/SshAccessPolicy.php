<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SshAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class SshAccessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sshAccess can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sshaccesses');
    }

    /**
     * Determine whether the sshAccess can view the model.
     */
    public function view(User $user, SshAccess $model): bool
    {
        return $user->hasPermissionTo('view sshaccesses');
    }

    /**
     * Determine whether the sshAccess can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sshaccesses');
    }

    /**
     * Determine whether the sshAccess can update the model.
     */
    public function update(User $user, SshAccess $model): bool
    {
        return $user->hasPermissionTo('update sshaccesses');
    }

    /**
     * Determine whether the sshAccess can delete the model.
     */
    public function delete(User $user, SshAccess $model): bool
    {
        return $user->hasPermissionTo('delete sshaccesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sshaccesses');
    }

    /**
     * Determine whether the sshAccess can restore the model.
     */
    public function restore(User $user, SshAccess $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sshAccess can permanently delete the model.
     */
    public function forceDelete(User $user, SshAccess $model): bool
    {
        return false;
    }
}
