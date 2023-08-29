<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\MoveToTrash;
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
    Livewire::test(MoveToTrash::class)
        ->assertStatus(200);
});

it('should move to trash a role', function () {
    $role = Role::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('role', $role)
        ->call('moveToTrash')
        ->assertEmittedTo(All::class, 'roles::trashed');

    $role = $role->fresh();

    expect($role)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('roles', [
        'id' => $role->id,
        'deleted_at' => $role->deleted_at,
    ]);
});

it('should not move to trash a role if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $role = Role::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('role', $role)
        ->call('moveToTrash');

    $role = $role->fresh();

    expect($role)
        ->deleted_at->toBeNull();

    assertDatabaseHas('roles', [
        'id' => $role->id,
        'deleted_at' => $role->deleted_at,
    ]);
});
