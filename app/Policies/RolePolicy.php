<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('roles-view');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('roles-view');
    }

    public function create(User $user): bool
    {
        return $user->can('roles-create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('roles-edit');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('roles-delete');
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->can('roles-delete');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $user->can('roles-delete');
    }
}
