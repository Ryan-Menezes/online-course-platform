<?php

use App\Http\Livewire\Courses\All;
use App\Http\Livewire\Courses\RecoverFromTrash;
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
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a course from the trash', function () {
    $course = Course::factory()->create();

    $course->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('course', $course)
        ->call('recoverFromTrash')
        ->assertEmittedTo(All::class, 'courses::recovered');

    $course = $course->fresh();

    expect($course)
        ->deleted_at->toBeNull();

    assertDatabaseHas('courses', [
        'id' => $course->id,
        'deleted_at' => $course->deleted_at,
    ]);
});

it('should not recover a course from the trash if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    $course->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('course', $course)
        ->call('recoverFromTrash');

    $course = $course->fresh();

    expect($course)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('courses', [
        'id' => $course->id,
        'deleted_at' => $course->deleted_at,
    ]);
});
