<?php

namespace App\Models;

use  App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Table_header extends Model
{
    use HasFactory;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['first' => 'json', 'second' => 'json', 'third' => 'json', 'fourth' => 'json'];
    public $translatable = ['first', 'second', 'third', 'fourth'];
}
