<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('courses-view');
    }

    public function view(User $user, Course $course): bool
    {
        return $user->can('courses-view');
    }

    public function create(User $user): bool
    {
        return $user->can('courses-create');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->can('courses-edit');
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->can('courses-delete');
    }

    public function restore(User $user, Course $course): bool
    {
        return $user->can('courses-delete');
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return $user->can('courses-delete');
    }
}
