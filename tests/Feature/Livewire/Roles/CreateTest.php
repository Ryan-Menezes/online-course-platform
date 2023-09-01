<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\Create;
use App\Models\Role;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('roles-create');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('should create a new role', function () {
    Livewire::test(Create::class)
        ->set('name', 'editor')
        ->set('label', 'Editor')
        ->set('description', 'Editor of the system')
        ->set('permissions', ['roles-view', 'roles-create'])
        ->call('save')
        ->assertEmittedTo(All::class, 'roles::created');

    assertDatabaseCount('permission_role', 3);
    assertDatabaseCount('roles', 2);
    assertDatabaseHas('roles', [
        'name' => 'editor',
        'label' => 'Editor',
        'description' => 'Editor of the system',
    ]);
});

it('should not create a new role if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    Livewire::test(Create::class)
        ->set('name', 'editor')
        ->set('label', 'Editor')
        ->set('description', 'Editor of the system')
        ->call('save');

    assertDatabaseCount('roles', 1);
    assertDatabaseMissing('roles', [
        'name' => 'editor',
        'label' => 'Editor',
        'description' => 'Editor of the system',
    ]);
});

test('the role name should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'name' => 'required',
        ]);

    assertDatabaseCount('roles', 1);
});

test('the role name should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('name', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max:191',
        ]);

    assertDatabaseCount('roles', 1);
});

test('the role name should be unique', function () {
    Role::factory()->create(['name' => 'editor']);

    Livewire::test(Create::class)
        ->set('name', 'editor')
        ->call('save')
        ->assertHasErrors([
            'name' => 'unique:roles',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role label should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'label' => 'required',
        ]);

    assertDatabaseCount('roles', 1);
});

test('the role label should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('label', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'label' => 'max:191',
        ]);

    assertDatabaseCount('roles', 1);
});

test('the role description should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'description' => 'required',
        ]);

    assertDatabaseCount('roles', 1);
});

test('the role description should be less than 300 characters long', function () {
    Livewire::test(Create::class)
        ->set('description', str('a')->repeat(301))
        ->call('save')
        ->assertHasErrors([
            'description' => 'max:300',
        ]);

    assertDatabaseCount('roles', 1);
});
