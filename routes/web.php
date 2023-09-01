<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\All as UsersAll;
use App\Http\Livewire\Users\Edit as UsersEdit;
use App\Http\Livewire\Files\All as FilesAll;
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
    Route::get('/users/{user}', UsersEdit::class)->name('users.edit');
    Route::get('/files', FilesAll::class)->name('files');
    Route::get('/roles', RolesAll::class)->name('roles');
    Route::get('/roles/{role}', RolesEdit::class)->name('roles.edit');
    Route::get('/permissions', PermissionsAll::class)->name('permissions');
});
