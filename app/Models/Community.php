<?php

namespace App\Models;

use  App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Community extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Localizable;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $casts = ['name' => 'json'];
    public $translatable = ['name'];

    public function product (){
        return $this->belongsTo(Product::class, 'community', 'id');
    }

    public function products (){
        return $this->hasMany(Product::class, 'community', 'id');
    }
}
