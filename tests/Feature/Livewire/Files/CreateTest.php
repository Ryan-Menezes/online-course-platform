<?php

use App\Http\Livewire\Files\All;
use App\Http\Livewire\Files\Create;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('files-create');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('should create a new file', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.png');
    $path = date('m-Y') . '/' . $file->getClientOriginalName();

    Livewire::test(Create::class)
        ->set('files', [$file])
        ->call('save')
        ->assertEmittedTo(All::class, 'files::created');

    assertDatabaseCount('files', 1);
    assertDatabaseHas('files', [
        'name' => $file->getClientOriginalName(),
        'mimetype' => $file->getMimeType(),
        'path' => $path,
    ]);

    Storage::disk('public')->assertExists($path);
});

it('should not create a new file if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.png');
    $path = date('m-Y') . '/' . $file->getClientOriginalName();

    Livewire::test(Create::class)
        ->set('files', [$file])
        ->call('save');

    assertDatabaseCount('files', 0);
    assertDatabaseMissing('files', [
        'name' => $file->getClientOriginalName(),
        'mimetype' => $file->getMimeType(),
        'path' => $path,
    ]);

    Storage::disk('public')->assertMissing($path);
});

test('the files should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'files' => 'required',
        ]);

    assertDatabaseCount('files', 0);
});

test('each file should be a valid file', function () {
    Livewire::test(Create::class)
        ->set('files', ['invalid-file'])
        ->call('save')
        ->assertHasErrors(['files.*']);

    assertDatabaseCount('files', 0);
});
