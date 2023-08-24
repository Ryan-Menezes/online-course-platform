<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            'users',
            'files',
            'courses',
            'roles',
            'permissions',
        ];

        $actions = [
            'view',
            'edit',
            'create',
            'delete',
        ];

        foreach ($tables as $table) {
            foreach ($actions as $action) {
                $label = str("{$action} {$table}")->ucfirst()->toString();

                Permission::query()->create([
                    'name' => "{$table}-{$action}",
                    'label' => $label,
                    'description' => "{$label} permission",
                ]);
            }
        }
    }
}
