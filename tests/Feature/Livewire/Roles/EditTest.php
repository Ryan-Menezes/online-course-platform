<?php

use App\Http\Livewire\Roles\All;
use App\Http\Livewire\Roles\Edit;
use App\Models\Role;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('roles-edit');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->assertStatus(200);
});

test('component cannot render if the user does not have authorization', function () {
    $user = User::factory()->create();
    $user->role->permissions()->sync([]);

    actingAs($user);

    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->assertForbidden();
});

it('should update a new role', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('name', 'editor')
        ->set('label', 'Editor')
        ->set('description', 'Editor of the system')
        ->set('permissions', ['roles-view', 'roles-create'])
        ->call('save');

    assertDatabaseCount('permission_role', 3);
    assertDatabaseCount('roles', 2);
    assertDatabaseHas('roles', [
        'name' => 'editor',
        'label' => 'Editor',
        'description' => 'Editor of the system',
    ]);
});

test('the role name should be required', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('name', '')
        ->call('save')
        ->assertHasErrors([
            'name' => 'required',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role name should be less than 191 characters long', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('name', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max:191',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role name should be unique', function () {
    Role::factory()->create(['name' => 'editor']);

    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('name', 'editor')
        ->call('save')
        ->assertHasErrors([
            'name' => 'unique:roles',
        ]);

    assertDatabaseCount('roles', 3);
});

test('the role label should be required', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('label', '')
        ->call('save')
        ->assertHasErrors([
            'label' => 'required',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role label should be less than 191 characters long', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('label', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'label' => 'max:191',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role description should be required', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('description', '')
        ->call('save')
        ->assertHasErrors([
            'description' => 'required',
        ]);

    assertDatabaseCount('roles', 2);
});

test('the role description should be less than 300 characters long', function () {
    $role = Role::factory()->create();

    Livewire::test(Edit::class, ['role' => $role])
        ->set('description', str('a')->repeat(301))
        ->call('save')
        ->assertHasErrors([
            'description' => 'max:300',
        ]);

    assertDatabaseCount('roles', 2);
});
