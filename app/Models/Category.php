<?php

namespace App\Models;

use  App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['name' => 'json'];
    public $translatable = ['name'];

    public function product (){
        return $this->belongsTo(Product::class, 'category', 'id');
    }
}
