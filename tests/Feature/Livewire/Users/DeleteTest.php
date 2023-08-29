<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\Delete;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('users-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('should delete a user', function () {
    $user = User::factory()->create();

    Livewire::test(Delete::class)
        ->set('user', $user)
        ->call('delete')
        ->assertEmittedTo(All::class, 'users::deleted');

    assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

it('should not delete a user if the user does not have authorization', function () {
    $userLog = User::factory()->create();
    $userLog->role->permissions()->sync([]);

    actingAs($userLog);

    $user = User::factory()->create();

    Livewire::test(Delete::class)
        ->set('user', $user)
        ->call('delete');

    assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
