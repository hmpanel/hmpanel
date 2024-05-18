<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WebApp;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebAppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the webApp can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list webapps');
    }

    /**
     * Determine whether the webApp can view the model.
     */
    public function view(User $user, WebApp $model): bool
    {
        return $user->hasPermissionTo('view webapps');
    }

    /**
     * Determine whether the webApp can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create webapps');
    }

    /**
     * Determine whether the webApp can update the model.
     */
    public function update(User $user, WebApp $model): bool
    {
        return $user->hasPermissionTo('update webapps');
    }

    /**
     * Determine whether the webApp can delete the model.
     */
    public function delete(User $user, WebApp $model): bool
    {
        return $user->hasPermissionTo('delete webapps');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete webapps');
    }

    /**
     * Determine whether the webApp can restore the model.
     */
    public function restore(User $user, WebApp $model): bool
    {
        return false;
    }

    /**
     * Determine whether the webApp can permanently delete the model.
     */
    public function forceDelete(User $user, WebApp $model): bool
    {
        return false;
    }
}
