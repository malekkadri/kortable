<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function update(User $user, User $target): bool
    {
        if (! $user->hasPermission('manage_users')) {
            return false;
        }

        return ! $target->hasRole('super_admin') || $user->id === $target->id;
    }

    public function assignRole(User $user, User $target): bool
    {
        if (! $user->hasPermission('manage_users')) {
            return false;
        }

        return ! $target->hasRole('super_admin') || $user->id === $target->id;
    }

    public function toggleStatus(User $user, User $target): bool
    {
        if (! $this->update($user, $target)) {
            return false;
        }

        return $user->id !== $target->id;
    }
}
