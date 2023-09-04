<?php

use App\Http\Livewire\Files\All;
use App\Http\Livewire\Files\MoveToTrash;
use App\Models\File;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('files-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);

    Storage::fake('public');
});

test('component can render', function () {
    Livewire::test(MoveToTrash::class)
        ->assertStatus(200);
});

it('should move to trash a file', function () {
    $file = File::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('file', $file)
        ->call('moveToTrash')
        ->assertEmittedTo(All::class, 'files::trashed');

    $file = $file->fresh();

    expect($file)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('files', [
        'id' => $file->id,
        'deleted_at' => $file->deleted_at,
    ]);

    Storage::disk('public')->assertExists($file->path);
});

it('should not move to trash a file if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $file = File::factory()->create();

    Livewire::test(MoveToTrash::class)
        ->set('file', $file)
        ->call('moveToTrash');

    $file = $file->fresh();

    expect($file)
        ->deleted_at->toBeNull();

    assertDatabaseHas('files', [
        'id' => $file->id,
        'deleted_at' => $file->deleted_at,
    ]);

    Storage::disk('public')->assertExists($file->path);
});
