<?php

namespace App\Models;

use  App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Table_data extends Model
{
    use HasFactory;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['type' => 'json'];
    public $translatable = ['type'];
}
