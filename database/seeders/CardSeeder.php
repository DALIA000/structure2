<?php

namespace Database\Seeders;

use App\Models\Statistics_card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Statistics_card::create([
            'Percentage' => 50,
            'description' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'number' => '100'
        ]);
        Statistics_card::create([
            'Percentage' => 100,
            'description' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
            'number' => '100'
        ]);
    }
}
