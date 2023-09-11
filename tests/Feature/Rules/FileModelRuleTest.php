<?php

use App\Models\File;
use App\Rules\FileModelRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

it('should allow the file', function () {
    $file = File::factory()->create([
        'mimetype' => 'image/jpeg',
    ]);

    Validator::make([
        'file' => $file,
    ], [
        'file' => new FileModelRule(),
    ])->validate();

    Validator::make([
        'file' => $file,
    ], [
        'file' => new FileModelRule(['image/jpeg']),
    ])->validate();
})->throwsNoExceptions();

it('should not allow the file with invalid mimetype', function () {
    $file = File::factory()->create([
        'mimetype' => 'image/jpeg',
    ]);

    Validator::make([
        'file' => $file,
    ], [
        'file' => new FileModelRule(['image/png', 'image/gif']),
    ])->validate();
})->throws(ValidationException::class, 'The specified file does not have the correct mimetype');

test('the file should be required', function () {
    Validator::make([
        'file' => null,
    ], [
        'file' => new FileModelRule(),
    ])->validate();
})->throws(ValidationException::class, 'The file field is required.');

test('the file should exist on files table', function () {
    $file = File::factory()->create();

    $validator = Validator::make([
        'file' => $file,
    ], [
        'file' => new FileModelRule(),
    ]);

    $file->forceDelete();

    $validator->validate();
})->throws(ValidationException::class, 'The selected file is invalid.');
