<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate([
            'name' => 'admin',
            'label' => 'Administrator',
            'description' => 'Administrator of the system',
        ]);

        User::factory()->create([
            'email' => 'menezesryan1010@gmail.com',
            'password' => bcrypt('123'),
            'role_id' => $adminRole->id,
        ]);

        User::factory(50)->create();
    }
}
