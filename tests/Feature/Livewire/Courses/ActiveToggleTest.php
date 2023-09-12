<?php

use App\Http\Livewire\Courses\ActiveToggle;
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

    Livewire::test(ActiveToggle::class, ['course' => $course])
        ->assertStatus(200);
});

it('should not update a course if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create([
        'active' => false,
    ]);

    Livewire::test(ActiveToggle::class, ['course' => $course])
        ->set('course.active', true);

    $course = $course->fresh();

    expect($course->active)->toBeFalsy();
});

it('should change the course visibility', function () {
    $course = Course::factory()->create([
        'active' => false,
    ]);

    Livewire::test(ActiveToggle::class, ['course' => $course])
        ->set('course.active', true);

    $course = $course->fresh();

    expect($course->active)->toBeTruthy();
});
