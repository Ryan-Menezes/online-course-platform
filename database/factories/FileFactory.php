<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'mimetype' => fake()->mimeType(),
            'path' => fake()->imageUrl(),
        ];
    }
}
