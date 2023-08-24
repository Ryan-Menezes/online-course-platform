<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\All as UsersAll;
use App\Http\Livewire\Roles\All as RolesAll;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UsersAll::class)->name('users');
    Route::get('/roles', RolesAll::class)->name('roles');
});
