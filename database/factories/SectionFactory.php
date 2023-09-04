<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory()->create()->id,
            'title' => fake()->sentence(),
            'order' => 1,
        ];
    }
}
