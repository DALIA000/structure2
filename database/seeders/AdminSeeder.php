<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $roles = Role::all();

        // Create or update the developer admin
        Admin::updateOrCreate(
            ['email' => 'developer@developer.com'],
            [
                'name' => 'developer',
                'username' => 'developer',
                'password' => 'developer',
            ]
        )->syncRoles($roles);

        // Create or update the admin admin
        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => 'admin',
            ]
        )->syncRoles($roles);
    }
}
