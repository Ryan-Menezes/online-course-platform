<?php

use App\Http\Livewire\Sections\All;
use App\Http\Livewire\Sections\Delete;
use App\Models\Section;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('courses-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('should delete a section', function () {
    $section = Section::factory()->create();

    Livewire::test(Delete::class, ['section' => $section])
        ->call('delete')
        ->assertEmittedTo(All::class, 'sections::deleted');

    assertDatabaseMissing('sections', [
        'id' => $section->id,
    ]);
});

it('should not delete a section if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $section = Section::factory()->create();

    Livewire::test(Delete::class, ['section' => $section])
        ->call('delete');

    assertDatabaseHas('sections', [
        'id' => $section->id,
    ]);
});
