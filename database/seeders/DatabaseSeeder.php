<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FileSeeder::class,
            CourseSeeder::class,
            SectionSeeder::class,
            ContentSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
