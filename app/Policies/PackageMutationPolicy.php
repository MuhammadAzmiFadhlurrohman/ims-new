<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PackageMutation;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageMutationPolicy
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
        return $user->can('view_any_package::mutation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('view_package::mutation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_package::mutation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('update_package::mutation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('delete_package::mutation');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_package::mutation');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('force_delete_package::mutation');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_package::mutation');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('restore_package::mutation');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_package::mutation');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PackageMutation $packageMutation): bool
    {
        return $user->can('replicate_package::mutation');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_package::mutation');
    }
}
