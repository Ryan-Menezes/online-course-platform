<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\RecoverFromTrash;
use App\Models\Role;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('roles-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a role from the trash', function () {
    $role = Role::factory()->create();

    $role->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('role', $role)
        ->call('recoverFromTrash')
        ->assertEmittedTo(All::class, 'roles::recovered');

    $role = $role->fresh();

    expect($role)
        ->deleted_at->toBeNull();

    assertDatabaseHas('roles', [
        'id' => $role->id,
        'deleted_at' => $role->deleted_at,
    ]);
});

it('should not recover a role from the trash if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $role = Role::factory()->create();

    $role->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('role', $role)
        ->call('recoverFromTrash');

    $role = $role->fresh();

    expect($role)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('roles', [
        'id' => $role->id,
        'deleted_at' => $role->deleted_at,
    ]);
});
