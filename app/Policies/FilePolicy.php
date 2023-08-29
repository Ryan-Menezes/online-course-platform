<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('files-view');
    }

    public function view(User $user, File $file): bool
    {
        return $user->can('files-view');
    }

    public function create(User $user): bool
    {
        return $user->can('files-create');
    }

    public function update(User $user, File $file): bool
    {
        return $user->can('files-edit');
    }

    public function delete(User $user, File $file): bool
    {
        return $user->can('files-delete');
    }

    public function restore(User $user, File $file): bool
    {
        return $user->can('files-delete');
    }

    public function forceDelete(User $user, File $file): bool
    {
        return $user->can('files-delete');
    }
}
