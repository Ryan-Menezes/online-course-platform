<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\RecoverFromTrash;
use App\Models\Role;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

test('component can render', function () {
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a role from trash', function () {
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
