<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agent::Create([
            'slug' => 'slug',
            "first_name" => [
                "ar" => "Arabic_First_Name",
                "en" => "English_First_Name",
                "ru" => "Russian_First_Name"
            ],
            "last_name" => [
                "ar" => "Arabic_Last_Name",
                "en" => "English_Last_Name",
                "ru" => "Russian_Last_Name"
            ],
            "position" => [
                "ar" => "Arabic_Position",
                "en" => "English_Position",
                "ru" => "Russian_Position"
            ],
            "lang" => [
                "ar" => "Arabic_Lang",
                "en" => "English_Lang",
                "ru" => "Russian_Lang"
            ],
            'service' => [],
        ]);
    }
}
