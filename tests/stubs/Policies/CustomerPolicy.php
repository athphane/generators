<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Javaabu\Activitylog\Models\Activity;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_customers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        return $user->can('view_customers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('edit_customers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $user->can('edit_customers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return $user->can('delete_customers');
    }

    /**
     * Determine whether the user can view trashed models.
     */
    public function viewTrash(User $user): bool
    {
        return $user->can('delete_customers') || $user->can('force_delete_customers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return $user->can('delete_customers') || $user->can('force_delete_customers');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        return $user->can('force_delete_customers');
    }

    /**
     * Determine whether the user can view the model logs.
     */
    public function viewLogs(User $user, Customer $customer): bool
    {
        return $user->can('viewAny', Activity::class) && $this->update($user, $customer);
    }

    /**
     * Determine whether the user can approve customers.
     */
    public function approve(User $user): bool
    {
        return $user->can('approve_customers') && $this->create($user);
    }

    /**
     * Determine whether the user can resend the verification for the customer.
     */
    public function resendVerification(User $user, Customer $customer): bool
    {
        return $customer->needsEmailVerification() && $this->update($user, $customer);
    }
}
