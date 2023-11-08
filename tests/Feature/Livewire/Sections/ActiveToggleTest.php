<?php

use App\Http\Livewire\Sections\ActiveToggle;
use App\Models\Section;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('courses-edit');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    $section = Section::factory()->create();

    Livewire::test(ActiveToggle::class, ['section' => $section])
        ->assertStatus(200);
});

it('should not update a section if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $section = Section::factory()->create([
        'active' => false,
    ]);

    Livewire::test(ActiveToggle::class, ['section' => $section])
        ->set('section.active', true);

    $section = $section->fresh();

    expect($section->active)->toBeFalsy();
});

it('should change the section visibility', function () {
    $section = Section::factory()->create([
        'active' => false,
    ]);

    Livewire::test(ActiveToggle::class, ['section' => $section])
        ->set('section.active', true);

    $section = $section->fresh();

    expect($section->active)->toBeTruthy();
});
