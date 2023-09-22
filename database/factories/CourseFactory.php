<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => fake()->sentence(),
            'file_thumb_id' => File::factory()->create()->id,
            'file_certificate_id' => File::factory()->create()->id,
            'active' => fake()->boolean(),
        ];
    }
}
