<?php

use App\Http\Controllers\Users\UserEditController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\All as UsersAll;
use App\Http\Livewire\Roles\All as RolesAll;
use App\Http\Livewire\Permissions\All as PermissionsAll;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UsersAll::class)->middleware('can:users-view')->name('users');
    Route::get('/users/{user}', UserEditController::class)->middleware('can:users-edit')->name('users.edit');
    Route::get('/roles', RolesAll::class)->middleware('can:roles-view')->name('roles');
    Route::get('/permissions', PermissionsAll::class)->middleware('can:permissions-view')->name('permissions');
});
