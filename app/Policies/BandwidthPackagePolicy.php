<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BandwidthPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class BandwidthPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bandwidth::package');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('view_bandwidth::package');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_bandwidth::package');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('update_bandwidth::package');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('delete_bandwidth::package');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_bandwidth::package');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('force_delete_bandwidth::package');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_bandwidth::package');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('restore_bandwidth::package');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_bandwidth::package');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, BandwidthPackage $bandwidthPackage): bool
    {
        return $user->can('replicate_bandwidth::package');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_bandwidth::package');
    }
}
