<?php

namespace Database\Seeders;

use App\Models\Table_data;
use App\Models\Table_header;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table_header = Table_header::create([
            'first' =>[
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'second' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'third' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'fourth' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ]
        ]);

        $table_data = Table_data::create([
            'type' =>[
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'price' => 100,
            'percent' => 50,
            'year' => '2014'
        ]);
    }
}
