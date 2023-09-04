<?php

use App\Http\Livewire\Files\All;
use App\Http\Livewire\Files\RecoverFromTrash;
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
    Livewire::test(RecoverFromTrash::class)
        ->assertStatus(200);
});

it('should recover a file from the trash', function () {
    $file = File::factory()->create();

    $file->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('file', $file)
        ->call('recoverFromTrash')
        ->assertEmittedTo(All::class, 'files::recovered');

    $file = $file->fresh();

    expect($file)
        ->deleted_at->toBeNull();

    assertDatabaseHas('files', [
        'id' => $file->id,
        'deleted_at' => $file->deleted_at,
    ]);

    Storage::disk('public')->assertExists($file->path);
});

it('should not recover a file from the trash if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $file = File::factory()->create();

    $file->delete();

    Livewire::test(RecoverFromTrash::class)
        ->set('file', $file)
        ->call('recoverFromTrash');

    $file = $file->fresh();

    expect($file)
        ->deleted_at->not->toBeNull();

    assertDatabaseHas('files', [
        'id' => $file->id,
        'deleted_at' => $file->deleted_at,
    ]);

    Storage::disk('public')->assertExists($file->path);
});
