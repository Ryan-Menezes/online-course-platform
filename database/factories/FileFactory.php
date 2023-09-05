<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'mimetype' => fake()->mimeType(),
            'path' => UploadedFile::fake()->image(uniqid())->store('test'),
        ];
    }
}
