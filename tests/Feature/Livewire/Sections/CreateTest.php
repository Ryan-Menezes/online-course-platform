<?php

namespace Tests\Feature\Livewire\Sections;

use App\Http\Livewire\Sections\All;
use App\Http\Livewire\Sections\Create;
use App\Models\Course;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('courses-create');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    $course = Course::factory()->create();

    Livewire::test(Create::class)
        ->set('course', $course)
        ->assertStatus(200);
});

it('should create a new section for a course', function () {
    $course = Course::factory()->create();

    Livewire::test(Create::class)
        ->set('course', $course)
        ->set('title', 'Test')
        ->set('active', true)
        ->call('save')
        ->assertEmittedTo(All::class, 'sections::created');

    assertDatabaseCount('sections', 1);
    assertDatabaseHas('sections', [
        'course_id' => $course->id,
        'title' => 'Test',
        'active' => true,
    ]);
});

it('should not create a new section if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    Livewire::test(Create::class)
        ->set('course', $course)
        ->set('title', 'Test')
        ->set('active', true)
        ->call('save');

    assertDatabaseCount('sections', 0);
    assertDatabaseMissing('sections', [
        'course_id' => $course->id,
        'title' => 'Test',
        'active' => true,
    ]);
});

test('the section title should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Create::class)
        ->set('course', $course)
        ->call('save')
        ->assertHasErrors([
            'title' => 'required',
        ]);

    assertDatabaseCount('sections', 0);
});

test('the section title should be less than 191 characters long', function () {
    $course = Course::factory()->create();

    Livewire::test(Create::class)
        ->set('course', $course)
        ->set('title', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'title' => 'max:191',
        ]);

    assertDatabaseCount('sections', 0);
});
