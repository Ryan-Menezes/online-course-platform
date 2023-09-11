<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::factory(10)->create([
            'file_thumb_id' => File::factory()->create([
                'path' => fake()->imageUrl(),
            ])->id,
            'file_certificate_id' => File::factory()->create([
                'path' => fake()->imageUrl(),
            ])->id,
        ]);
    }
}
