<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\MoveToTrash;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('users-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(MoveToTrash::class)
        ->assertStatus(200);
});

it('should move to trash a user', function () {
    $user = User::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('user', $user)
        ->call('moveToTrash')
        ->assertEmittedTo(All::class, 'users::trashed');

    $user = $user->fresh();

    expect($user)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => $user->deleted_at,
    ]);
});

it('should not move to trash a user if the user does not have authorization', function () {
    $userLog = User::factory()->create();
    $userLog->role->permissions()->sync([]);

    actingAs($userLog);

    $user = User::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('user', $user)
        ->call('moveToTrash');

    $user = $user->fresh();

    expect($user)
        ->deleted_at->toBeNull();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => $user->deleted_at,
    ]);
});
