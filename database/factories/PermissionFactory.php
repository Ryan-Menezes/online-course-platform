<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'label' => fake()->sentence(),
            'description' => fake()->sentence(),
        ];
    }
}
