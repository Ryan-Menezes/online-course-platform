<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'label' => 'Administrator',
                'permissions' => [
                    'users-view',
                    'users-edit',
                    'users-create',
                    'users-delete',

                    'files-view',
                    'files-edit',
                    'files-create',
                    'files-delete',

                    'courses-view',
                    'courses-edit',
                    'courses-create',
                    'courses-delete',

                    'roles-view',
                    'roles-edit',
                    'roles-create',
                    'roles-delete',

                    'permissions-view',
                    'permissions-edit',
                    'permissions-create',
                    'permissions-delete',
                ],
            ],
            'manager' => [
                'label' => 'Manager',
                'permissions' => [
                    'files-view',
                    'files-edit',
                    'files-create',
                    'files-delete',

                    'courses-view',
                    'courses-edit',
                    'courses-create',
                    'courses-delete',
                ],
            ],
            'user' => [
                'label' => 'User',
                'permissions' => [
                    'courses-view',
                ],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::query()->create([
                'name' => $name,
                'label' => $data['label'],
                'description' => "{$data['label']} of the system",
            ]);

            $role->givePermissions($data['permissions']);
        }
    }
}
