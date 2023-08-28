<?php

use App\Http\Livewire\Users\Edit;
use App\Models\Role;
use App\Models\User;
use Laravel\Fortify\Rules\Password;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

test('component can render', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->assertStatus(200);
});

it('should edit a user', function () {
    $role = Role::factory()->create();
    $user = User::factory()->create([
        'name' => 'Ben',
        'email' => 'ben@mail.com',
    ]);

    Livewire::test(Edit::class, ['user' => $user])
        ->set('name', 'John Doe')
        ->set('email', 'john@mail.com')
        ->set('role_id', $role->id)
        ->call('save');

    assertDatabaseCount('users', 1);
    assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@mail.com',
        'role_id' => $role->id,
    ]);
});

test('the user name should be required', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('name', '')
        ->call('save')
        ->assertHasErrors([
            'name' => 'required',
        ]);
});

test('the user name should be less than 191 characters long', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('name', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max:191',
        ]);
});

test('the user email should be required', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('email', '')
        ->call('save')
        ->assertHasErrors([
            'email' => 'required',
        ]);
});

test('the user email should be a valid email', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('email', 'invalid-email')
        ->call('save')
        ->assertHasErrors([
            'email' => 'email',
        ]);
});

test('the user email should be less than 191 characters long', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('email', str('a')->repeat(192) . '@mail.com')
        ->call('save')
        ->assertHasErrors([
            'email' => 'max:191',
        ]);
});

test('the user email should be unique', function () {
    User::factory()->create(['email' => 'john@mail.com']);

    $user = User::factory()->create(['email' => 'ben@mail.com']);

    Livewire::test(Edit::class, ['user' => $user])
        ->set('email', 'john@mail.com')
        ->call('save')
        ->assertHasErrors([
            'email' => 'unique:users',
        ]);
});

test('the role id should be required', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('role_id', '')
        ->call('save')
        ->assertHasErrors([
            'role_id' => 'required',
        ]);
});

test('the role id should exist on roles table', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('role_id', 'invalid_role_id')
        ->call('save')
        ->assertHasErrors([
            'role_id' => 'exists:roles,id',
        ]);
});

test('the user password should be greater than 8 characters long', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('password', '1234567')
        ->call('save')
        ->assertHasErrors([
            'password' => Password::class,
        ]);
});

test('the user password should be confirmed', function () {
    $user = User::factory()->create();

    Livewire::test(Edit::class, ['user' => $user])
        ->set('password', '12345678')
        ->call('save')
        ->assertHasErrors([
            'password' => 'confirmed',
        ]);
});
