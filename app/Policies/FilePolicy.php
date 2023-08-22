<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, File $file): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, File $file): bool
    {
        //
    }

    public function delete(User $user, File $file): bool
    {
        //
    }

    public function restore(User $user, File $file): bool
    {
        //
    }

    public function forceDelete(User $user, File $file): bool
    {
        //
    }
}
