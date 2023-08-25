<?php

use App\Http\Livewire\Users\All;
use App\Http\Livewire\Users\Create;
use Laravel\Fortify\Rules\Password;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('should create a new user', function () {
    Livewire::test(Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@mail.com')
        ->set('password', '12345678')
        ->set('password_confirmation', '12345678')
        ->call('save')
        ->assertEmittedTo(All::class, 'users::created');

    assertDatabaseCount('users', 1);
    assertDatabaseHas('users', [
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

    assertDatabaseCount('users', 0);
});

test('the user name should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('name', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max:191',
        ]);

    assertDatabaseCount('users', 0);
});

test('the user email should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'email' => 'required',
        ]);

    assertDatabaseCount('users', 0);
});

test('the user email should be a valid email', function () {
    Livewire::test(Create::class)
        ->set('email', 'invalid-email')
        ->call('save')
        ->assertHasErrors([
            'email' => 'email',
        ]);

    assertDatabaseCount('users', 0);
});

test('the user email should be less than 191 characters long', function () {
    Livewire::test(Create::class)
        ->set('email', str('a')->repeat(192))
        ->call('save')
        ->assertHasErrors([
            'email' => 'max:191',
        ]);

    assertDatabaseCount('users', 0);
});

test('the user password should be required', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'password' => 'required',
        ]);

    assertDatabaseCount('users', 0);
});

test('the user password should be greater than 8 characters long', function () {
    Livewire::test(Create::class)
        ->set('password', '1234567')
        ->call('save')
        ->assertHasErrors([
            'password' => Password::class,
        ]);

    assertDatabaseCount('users', 0);
});

test('the user password should be confirmed', function () {
    Livewire::test(Create::class)
        ->set('password', '12345678')
        ->call('save')
        ->assertHasErrors([
            'password' => 'confirmed',
        ]);

    assertDatabaseCount('users', 0);
});