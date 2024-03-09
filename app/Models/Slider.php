<?php

namespace App\Models;

use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;



class Slider extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['title' => 'json', 'description' => 'json', 'filter_title' => 'json'];
    public $translatable = ['title', 'description', 'filter_title'];
}
