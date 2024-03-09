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
        $permissions = Permission::all();

        $roleData = [
            "name" => 'super',
            "title" => [
                "en" => "super",
                "ar" => "سوبر"
            ],
            "guard_name" => 'admin'
        ];

        // Use updateOrCreate to create a new role or update an existing one
        $role = Role::updateOrCreate(
            ['name' => 'super'],
            $roleData
        );

        // Sync permissions
        $role->syncPermissions($permissions);
    }
}
