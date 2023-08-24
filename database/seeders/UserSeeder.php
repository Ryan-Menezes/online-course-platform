<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'email' => 'menezesryan1010@gmail.com',
            'password' => bcrypt('123'),
        ]);

        User::factory(50)->create();
    }
}
