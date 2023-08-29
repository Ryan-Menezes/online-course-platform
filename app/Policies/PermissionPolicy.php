<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('permissions-view');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->can('permissions-view');
    }

    public function create(User $user): bool
    {
        return $user->can('permissions-create');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->can('permissions-edit');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('permissions-delete');
    }

    public function restore(User $user, Permission $permission): bool
    {
        return $user->can('permissions-delete');
    }

    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->can('permissions-delete');
    }
}
