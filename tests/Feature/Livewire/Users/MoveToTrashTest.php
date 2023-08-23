<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\MoveToTrash;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

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
