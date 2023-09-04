<?php

use App\Http\Livewire\Files\All;
use App\Http\Livewire\Files\Delete;
use App\Models\File;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('files-delete');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);

    Storage::fake('public');
});

test('component can render', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('should delete a file', function () {
    $file = File::factory()->create();

    Livewire::test(Delete::class)
        ->set('file', $file)
        ->call('delete')
        ->assertEmittedTo(All::class, 'files::deleted');

    assertDatabaseMissing('files', [
        'id' => $file->id,
    ]);

    Storage::disk('public')->assertMissing($file->path);
});

it('should not delete a file if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $file = File::factory()->create();

    Livewire::test(Delete::class)
        ->set('file', $file)
        ->call('delete');

    assertDatabaseHas('files', [
        'id' => $file->id,
    ]);

    Storage::disk('public')->assertExists($file->path);
});
