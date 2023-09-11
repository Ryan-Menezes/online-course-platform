<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\File;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
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

        Section::factory(10)->create([
            'course_id' => $course->id,
        ]);
    }
}
