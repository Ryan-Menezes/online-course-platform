<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\RecoverFromTrash;
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
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a user from the trash', function () {
    $user = User::factory()->create();

    $user->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('user', $user)
        ->call('recoverFromTrash')
        ->assertEmittedTo(All::class, 'users::recovered');

    $user = $user->fresh();

    expect($user)
        ->deleted_at->toBeNull();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => $user->deleted_at,
    ]);
});

it('should not recover a user from the trash if the user does not have authorization', function () {
    $userLog = User::factory()->create();
    $userLog->role->permissions()->sync([]);

    actingAs($userLog);

    $user = User::factory()->create();

    $user->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('user', $user)
        ->call('recoverFromTrash');

    $user = $user->fresh();

    expect($user)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => $user->deleted_at,
    ]);
});
