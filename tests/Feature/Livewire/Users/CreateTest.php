<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\Create;
use App\Models\Role;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Laravel\Fortify\Rules\Password;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $user = User::factory()->create();
    $user->role->givePermission('users-create');

    (new AppServiceProvider(app()))->boot();

    actingAs($user);
});

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('should create a new user', function () {
    $role = Role::factory()->create();

    Livewire::test(Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@mail.com')
        ->set('role_id', $role->id)
        ->set('password', '12345678')
        ->set('password_confirmation', '12345678')
        ->call('save')
        ->assertEmittedTo(All::class, 'users::created');

    assertDatabaseCount('users', 2);
    assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@mail.com',
    ]);
});

it('should not create a new user if the user does not have authorization', function () {
    $userLog = User::factory()->create();
    $userLog->role->permissions()->sync([]);

    actingAs($userLog);

    $role = Role::factory()->create();

    Livewire::test(Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@mail.com')
        ->set('role_id', $role->id)
        ->set('password', '12345678')
        ->set('password_confirmation', '12345678')
        ->call('save');

    assertDatabaseCount('users', 2);
    assertDatabaseMissing('users', [
        'name' => 'John Doe',
        'email' => 'john@mail.com',
    ]);
});

test('the user name should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'name' => 'required',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user name should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('name', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max:191',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user email should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'email' => 'required',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user email should be a valid email', function () {
    Livewire::test(Create::class)
        ->set('email', 'invalid-email')
        ->call('save')
        ->assertHasErrors([
            'email' => 'email',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user email should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('email', str('a')->repeat(192) . '@mail.com')
        ->call('save')
        ->assertHasErrors([
            'email' => 'max:191',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user email should be unique', function () {
    User::factory()->create(['email' => 'john@mail.com']);

    Livewire::test(Create::class)
        ->set('email', 'john@mail.com')
        ->call('save')
        ->assertHasErrors([
            'email' => 'unique:users',
        ]);

    assertDatabaseCount('users', 2);
});

test('the role id should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'role_id' => 'required',
        ]);

    assertDatabaseCount('users', 1);
});

test('the role id should exist on roles table', function () {
    Livewire::test(Create::class)
        ->set('role_id', 'invalid_role_id')
        ->call('save')
        ->assertHasErrors([
            'role_id' => 'exists:roles,id',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user password should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'password' => 'required',
        ]);

    assertDatabaseCount('users', 1);
});

test('the user password should be greater than 8 characters long', function () {
    Livewire::test(Create::class)
        ->set('password', '1234567')
        ->call('save')
        ->assertHasErrors([
            'password' => Password::class,
        ]);

    assertDatabaseCount('users', 1);
});

test('the user password should be confirmed', function () {
    Livewire::test(Create::class)
        ->set('password', '12345678')
        ->call('save')
        ->assertHasErrors([
            'password' => 'confirmed',
        ]);

    assertDatabaseCount('users', 1);
});
