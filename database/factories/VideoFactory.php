<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory()->create()->id,
            'file_thumb_id' => File::factory()->create()->id,
            'file_video_id' => File::factory()->create()->id,
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
        ];
    }
}
