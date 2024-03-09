<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;


class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About Us
        $aboutUs = AboutUs::create([
            'type' => 'about',
            'title' => [
                'ar' => 'عنوان من نحن',
                'en' => 'About Us Title',
                'ru' => 'Заголовок О нас',
            ],
            'description' => [
                'ar' => 'وصف من نحن',
                'en' => 'About Us Description',
                'ru' => 'Описание О нас',
            ],
        ]);

        // Why Us
        $whyUs = AboutUs::create([
            'type' => 'why',
            'title' => [
                'ar' => 'عنوان لماذا نحن',
                'en' => 'Why Us Title',
                'ru' => 'Заголовок Почему мы',
            ],
        ]);

        // Benefits
        $benefits = AboutUs::create([
            'type' => 'benefits',
            'title' => [
                'ar' => 'عنوان الفائدة',
                'en' => 'Benefits Title',
                'ru' => 'Заголовок Преимущества',
            ],
            'description' => [
                'ar' => 'وصف الفائدة',
                'en' => 'Benefits Description',
                'ru' => 'Описание Преимуществ',
            ],
        ]);

        $aboutUs->addMedia(public_path('images/test.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('images');

        for($i = 0; $i < 4; $i++) {
            $whyUs->addMedia(public_path('images/test.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('images');
        }
    }
}
