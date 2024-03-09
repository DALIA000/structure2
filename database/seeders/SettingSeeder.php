<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $social = Setting::create([
            'slug' => 'social',
            'text' => [],
            'info' => [
                'facebook' => 'facebook.com',
                'twitter' => 'twitter.com',
                'instagram' => 'instagram.com',
                'linkedin' => 'linkedin.com',
                'tiktok' => 'tiktok.com',
            ],
        ]);

        $address = Setting::create([
            'slug' => 'address',
            'text' => [
                'ar' => 'Lorem Ipsum is simply',
                'en' => 'Lorem Ipsum is simply',
                'ru' => 'Lorem Ipsum is simply',
            ],
        ]);

        $location = Setting::create([
            'slug' => 'location',
            'text' => [],
            'info' => [
                'lat' => '100',
                'long' => '300',
            ],
        ]);

        $contacts = Setting::create([
            'slug' => 'contacts',
            'text' => [],
            'info' => [
                'whatsapp' => '0123456789',
                'phone' => '0123456789',
                'email' => 'company@gmail.com',
            ],
        ]);

        $privacy = Setting::create([
            'slug' => 'privacy',
            'text' => [
                'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ar' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ru' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            ],
        ]);

        $terms = Setting::create([
            'slug' => 'terms',
            'text' => [
                'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ar' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ru' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            ],
        ]);

        $currency = Setting::create([
            'slug' => 'currency',
            'text' => [
                'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ar' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ru' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            ],
        ]);

        $statistics_title = Setting::create([
            'slug' => 'statistics_title',
            'text' => [
                'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ar' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ru' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            ],
        ]);

        $table_title = Setting::create([
            'slug' => 'table_title',
            'text' => [
                'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ar' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'ru' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            ],
        ]);

        $currency->addMedia(public_path('images/test.jpg'))
        ->preservingOriginal()
        ->toMediaCollection('images');
    }
}
