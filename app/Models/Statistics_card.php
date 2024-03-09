<?php

namespace App\Models;

use  App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Statistics_card extends Model
{
    use HasFactory;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['description' => 'json'];
    public $translatable = ['description'];
}
