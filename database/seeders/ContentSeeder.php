<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Course;
use App\Models\File;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {

        $course = Course::factory()->create([
            'file_thumb_id' => File::factory()->create([
                'path' => fake()->imageUrl(),
            ])->id,
            'file_certificate_id' => File::factory()->create([
                'path' => fake()->imageUrl(),
            ])->id,
        ]);

        $section = Section::factory()->create([
            'course_id' => $course->id,
        ]);

        Content::factory(10)->create([
            'section_id' => $section->id,
            'file_thumb_id' => File::factory()->create([
                'path' => fake()->imageUrl(),
            ])->id,
            'file_video_id' => null,
        ]);
    }
}
