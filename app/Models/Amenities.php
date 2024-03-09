<?php

namespace App\Models;

use  App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Amenities extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Localizable;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $casts = ['name' => 'json'];
    public $translatable = ['name'];

}
