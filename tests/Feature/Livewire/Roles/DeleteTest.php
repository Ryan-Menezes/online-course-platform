<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\Delete;
use App\Models\Role;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('roles-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('should delete a role', function () {
    $role = Role::factory()->create();

    Livewire::test(Delete::class)
        ->set('role', $role)
        ->call('delete')
        ->assertEmittedTo(All::class, 'roles::deleted');

    assertDatabaseMissing('roles', [
        'id' => $role->id,
    ]);
});

it('should not delete a role if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $role = Role::factory()->create();

    Livewire::test(Delete::class)
        ->set('role', $role)
        ->call('delete');

    assertDatabaseHas('roles', [
        'id' => $role->id,
    ]);
});
