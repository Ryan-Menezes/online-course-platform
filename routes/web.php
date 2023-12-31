<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\All as UsersAll;
use App\Http\Livewire\Users\Edit as UsersEdit;
use App\Http\Livewire\Files\All as FilesAll;
use App\Http\Livewire\Courses\All as CoursesAll;
use App\Http\Livewire\Courses\Create as CoursesCreate;
use App\Http\Livewire\Courses\Edit as CoursesEdit;
use App\Http\Livewire\Roles\All as RolesAll;
use App\Http\Livewire\Roles\Edit as RolesEdit;
use App\Http\Livewire\Permissions\All as PermissionsAll;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UsersAll::class)->name('users');
    Route::get('/users/{user}/edit', UsersEdit::class)->name('users.edit')->withTrashed();
    Route::get('/files', FilesAll::class)->name('files');
    Route::get('/roles', RolesAll::class)->name('roles');
    Route::get('/courses', CoursesAll::class)->name('courses');
    Route::get('/courses/create', CoursesCreate::class)->name('courses.create');
    Route::get('/courses/{course}/edit', CoursesEdit::class)->name('courses.edit');
    Route::get('/roles/{role}/edit', RolesEdit::class)->name('roles.edit')->withTrashed();
    Route::get('/permissions', PermissionsAll::class)->name('permissions');
});
