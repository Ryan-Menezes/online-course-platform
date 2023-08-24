<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\Delete;
use App\Models\Role;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseMissing;

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
