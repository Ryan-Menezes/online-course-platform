<?php

use App\Http\Livewire\Permissions\All;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('permissions-view');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(All::class)
        ->assertStatus(200);
});

test('component cannot render if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    Livewire::test(All::class)
        ->assertForbidden();
});
