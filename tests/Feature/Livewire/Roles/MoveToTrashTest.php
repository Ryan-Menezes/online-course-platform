<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\MoveToTrash;
use App\Models\Role;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

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
