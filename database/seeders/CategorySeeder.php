<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'new-project',
                'name' => [
                    'en' => 'New project',
                    'ar' => 'New project',
                    'ru' => 'New project',
                ]
            ],
            [
                'slug' => 'luxury',
                'name' => [
                    'en' => 'Luxury',
                    'ar' => 'Luxury',
                    'ru' => 'Luxury',
                ]
            ],
            [
                'slug' => 'buy',
                'name' => [
                    'en' => 'Buy',
                    'ar' => 'Buy',
                    'ru' => 'Buy',
                ]
            ],
            [
                'slug' => 'sell',
                'name' => [
                    'en' => 'sell',
                    'ar' => 'sell',
                    'ru' => 'sell',
                ]
            ],
            [
                'slug' => 'rent',
                'name' => [
                    'en' => 'Rent',
                    'ar' => 'Rent',
                    'ru' => 'Rent',
                ]
            ],
        ];
        foreach ($data as $data) {
            Category::create([
                'slug' => $data['slug'],
                'name' => $data['name'],
            ]);
        }
    }
}
