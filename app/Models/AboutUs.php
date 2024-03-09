<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutUs extends Model implements HasMedia
{
    use HasFactory, Localizable, HasTranslations, InteractsWithMedia;
    protected $guarded = ['id'];
    public $translatable = ['title', 'description'];
    protected $casts = [
        'title' => 'json',
        'description' => 'json',
    ];
}
