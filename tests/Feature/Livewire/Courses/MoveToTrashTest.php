<?php

use App\Http\Livewire\Courses\All;
use App\Http\Livewire\Courses\MoveToTrash;
use App\Models\Course;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('courses-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(MoveToTrash::class)
        ->assertStatus(200);
});

it('should move to trash a course', function () {
    $course = Course::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('course', $course)
        ->call('moveToTrash')
        ->assertEmittedTo(All::class, 'courses::trashed');

    $course = $course->fresh();

    expect($course)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('courses', [
        'id' => $course->id,
        'deleted_at' => $course->deleted_at,
    ]);
});

it('should not move to trash a course if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('course', $course)
        ->call('moveToTrash');

    $course = $course->fresh();

    expect($course)
        ->deleted_at->toBeNull();

    assertDatabaseHas('courses', [
        'id' => $course->id,
        'deleted_at' => $course->deleted_at,
    ]);
});
