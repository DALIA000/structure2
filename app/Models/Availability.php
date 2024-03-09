<?php

namespace App\Models;

use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Availability extends Model
{
    use HasFactory, HasTranslations, Localizable;

    protected $guarded = ['id'];
    protected $casts = ['name' => 'json'];
    public $translatable = ['name'];

}
