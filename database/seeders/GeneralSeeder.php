<?php

namespace Database\Seeders;

use App\Models\FormImage;
use App\Models\General;
use App\Models\Interest;
use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $pdf = General::create([
            'slug' => 'pdf'
        ]);

        $about = General::create([
            'slug' => 'about'
        ]);

        $slider = Slider::create([
            'id' => 1,
            'title' => [
                'en' => 'Lorem Ipsum',
                'ar' => 'Lorem Ipsum',
                'ru' => 'Lorem Ipsum',
            ],
        ]);

        $expertImage = FormImage::create([
            'id' => 1,
        ]);

        $addYourList = FormImage::create([
            'id' => 2,
        ]);

        $about->addMedia(public_path('images/test.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('images');

        $pdf->addMedia(public_path('images/pdf.pdf'))
            ->preservingOriginal()
            ->toMediaCollection('files');

        $slider->addMedia(public_path('images/test.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('images');

        $expertImage->addMedia(public_path('images/test.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('images');

        for($i = 0; $i < 5; $i++) {
            $addYourList->addMedia(public_path('images/test.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('images');
        }
    }
}
