<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ServiceSuspension;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceSuspensionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super_admin') || $user->hasAnyRole(['noc', 'noc_support', 'finance'])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_service::suspension');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('view_service::suspension');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_service::suspension');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('update_service::suspension');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('delete_service::suspension');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_service::suspension');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('force_delete_service::suspension');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_service::suspension');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('restore_service::suspension');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_service::suspension');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ServiceSuspension $serviceSuspension): bool
    {
        return $user->can('replicate_service::suspension');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_service::suspension');
    }
}
