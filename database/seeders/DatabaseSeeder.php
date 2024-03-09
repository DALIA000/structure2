<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            AgentSeeder::class,
            DeveloperSeeder::class,
            TypeSeeder::class,
            CommunitySeeder::class,
            AmenitiesSeeder::class,
            SettingSeeder::class,
            GeneralSeeder::class,
            StatisticsSeeder::class,
            CardSeeder::class,
            AboutUsTableSeeder::class,
        ]);
    }
}
