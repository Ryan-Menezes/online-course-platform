<?php

use App\Http\Livewire\Sections\All;
use App\Models\Course;
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
    $course = Course::factory()->create();

    Livewire::test(All::class, ['course' => $course])
        ->assertStatus(200);
});

test('component cannot render if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    Livewire::test(All::class, ['course' => $course])
        ->assertForbidden();
});
