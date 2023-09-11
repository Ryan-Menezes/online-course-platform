<?php

use App\Http\Livewire\Courses\All;
use App\Http\Livewire\Courses\Delete;
use App\Models\Course;
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

it('should delete a course', function () {
    $course = Course::factory()->create();

    Livewire::test(Delete::class)
        ->set('course', $course)
        ->call('delete')
        ->assertEmittedTo(All::class, 'courses::deleted');

    assertDatabaseMissing('courses', [
        'id' => $course->id,
    ]);
});

it('should not delete a course if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    Livewire::test(Delete::class)
        ->set('course', $course)
        ->call('delete');

    assertDatabaseHas('courses', [
        'id' => $course->id,
    ]);
});
