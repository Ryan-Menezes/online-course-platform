<?php

use App\Http\Livewire\Courses\Create;
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
    $user->role->givePermission('courses-create');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('component cannot render if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    Livewire::test(Create::class)
        ->assertForbidden();
});

it('should create a new course', function () {
    $thumb = File::factory()->create();
    $certificate = File::factory()->create();

    Livewire::test(Create::class)
        ->set('file_thumb_id', $thumb->id)
        ->set('file_certificate_id', $certificate->id)
        ->set('title', 'Test')
        ->set('slug', 'test')
        ->set('description', 'Test create')
        ->set('active', true)
        ->call('save');

    assertDatabaseCount('courses', 1);
    assertDatabaseHas('courses', [
        'file_thumb_id' => $thumb->id,
        'file_certificate_id' => $certificate->id,
        'title' => 'Test',
        'slug' => 'test',
        'description' => 'Test create',
        'active' => true,
    ]);
});

test('when the title changed your value and the slug is empty, the slug should change your value', function () {
    Livewire::test(Create::class)
        ->set('title', 'Test title')
        ->assertSet('slug', 'test-title');
});

test('if the title changed your value when the slug is not empty, the slug should not change your value', function () {
    Livewire::test(Create::class)
        ->set('slug', 'other-slug')
        ->set('title', 'Test title')
        ->assertSet('slug', 'other-slug');
});

test('the course title should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'title' => 'required',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the course title should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('title', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'title' => 'max:191',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the course slug should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'slug' => 'required',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the course slug should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('slug', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'slug' => 'max:191',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the course slug should be unique', function () {
    Course::factory()->create(['slug' => 'test']);

    Livewire::test(Create::class)
        ->set('slug', 'test')
        ->call('save')
        ->assertHasErrors([
            'slug' => 'unique:courses',
        ]);

    assertDatabaseCount('courses', 1);
});

test('the course description should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'description' => 'required',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the course description should be less than 300 characters long', function () {
    Livewire::test(Create::class)
        ->set('description', str('a')->repeat(301))
        ->call('save')
        ->assertHasErrors([
            'description' => 'max:300',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the file thumb id should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'file_thumb_id' => 'required',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the file thumb id should exist on files table', function () {
    Livewire::test(Create::class)
        ->set('file_thumb_id', 'invalid_id')
        ->call('save')
        ->assertHasErrors([
            'file_thumb_id' => 'exists:files',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the file certificate id should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'file_certificate_id' => 'required',
        ]);

    assertDatabaseCount('courses', 0);
});

test('the file certificate id should exist on files table', function () {
    Livewire::test(Create::class)
        ->set('file_certificate_id', 'invalid_id')
        ->call('save')
        ->assertHasErrors([
            'file_certificate_id' => 'exists:files',
        ]);

    assertDatabaseCount('courses', 0);
});
