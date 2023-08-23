<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\RecoverFromTrash;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

test('component can render', function () {
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a user from trash', function () {
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
