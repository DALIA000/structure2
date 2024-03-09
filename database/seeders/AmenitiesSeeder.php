<?php

namespace Database\Seeders;

use App\Models\Amenities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Amenities::Create([
            'slug' => 'Amenities',
            'name' => [
                'ar' => 'amenities',
                'en' => 'amenities',
                'ru' => 'amenities',
            ]
        ]);
    }
}
