<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Javaabu\Activitylog\Models\Activity;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_products');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->can('view_products');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('edit_products');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->can('edit_products');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->can('delete_products');
    }

    /**
     * Determine whether the user can view trashed models.
     */
    public function viewTrash(User $user): bool
    {
        return $user->can('delete_products') || $user->can('force_delete_products');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->can('delete_products') || $user->can('force_delete_products');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->can('force_delete_products');
    }

    /**
     * Determine whether the user can view the model logs.
     */
    public function viewLogs(User $user, Product $product): bool
    {
        return $user->can('viewAny', Activity::class) && $this->update($user, $product);
    }
}
