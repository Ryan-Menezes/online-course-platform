<?php

use App\Http\Livewire\Courses\Edit;
use App\Models\Course;
use App\Models\File;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('courses-edit');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->assertStatus(200);
});

test('component cannot render if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->assertForbidden();
});

it('should edit a course', function () {
    $thumb = File::factory()->create();
    $certificate = File::factory()->create();

    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('file_thumb_id', $thumb->id)
        ->set('file_certificate_id', $certificate->id)
        ->set('title', 'Test')
        ->set('slug', 'test')
        ->set('description', 'Test edit')
        ->set('active', true)
        ->call('save');

    assertDatabaseCount('courses', 1);
    assertDatabaseHas('courses', [
        'file_thumb_id' => $thumb->id,
        'file_certificate_id' => $certificate->id,
        'title' => 'Test',
        'slug' => 'test',
        'description' => 'Test edit',
        'active' => true,
    ]);
});

test('when the title changed your value and the slug is empty, the slug should change your value', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('slug', '')
        ->set('title', 'Test title')
        ->assertSet('slug', 'test-title');
});

test('if the title changed your value when the slug is not empty, the slug should not change your value', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('slug', 'other-slug')
        ->set('title', 'Test title')
        ->assertSet('slug', 'other-slug');
});

test('the course title should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('title', '')
        ->call('save')
        ->assertHasErrors([
            'title' => 'required',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course title should be less than 191 characters long', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('title', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'title' => 'max:191',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course slug should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('slug', '')
        ->call('save')
        ->assertHasErrors([
            'slug' => 'required',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course slug should be less than 191 characters long', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('slug', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'slug' => 'max:191',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course slug should be unique', function () {
    Course::factory()->create(['slug' => 'test']);

    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('slug', 'test')
        ->call('save')
        ->assertHasErrors([
            'slug' => 'unique:courses',
        ]);

    assertDatabaseCount('courses', 2);
});

test('the course description should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('description', '')
        ->call('save')
        ->assertHasErrors([
            'description' => 'required',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course description should be less than 300 characters long', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('description', str('a')->repeat(301))
        ->call('save')
        ->assertHasErrors([
            'description' => 'max:300',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the file thumb id should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('file_thumb_id', '')
        ->call('save')
        ->assertHasErrors([
            'file_thumb_id' => 'required',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the file thumb id should exist on files table', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('file_thumb_id', 'invalid_id')
        ->call('save')
        ->assertHasErrors([
            'file_thumb_id' => 'exists:files',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the file certificate id should be required', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('file_certificate_id', '')
        ->call('save')
        ->assertHasErrors([
            'file_certificate_id' => 'required',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the file certificate id should exist on files table', function () {
    $course = Course::factory()->create();

    Livewire::test(Edit::class, ['course' => $course])
        ->set('file_certificate_id', 'invalid_id')
        ->call('save')
        ->assertHasErrors([
            'file_certificate_id' => 'exists:files',
        ]);

    assertDatabaseCount('courses', 1);
});
