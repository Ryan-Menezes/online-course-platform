<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'section_id' => Section::factory()->create()->id,
            'file_thumb_id' => File::factory()->create()->id,
            'file_video_id' => File::factory()->create()->id,
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
        ];
    }
}
