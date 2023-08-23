<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\Delete;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseMissing;

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
