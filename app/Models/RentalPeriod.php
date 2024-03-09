<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Localizable;

class RentalPeriod extends Model
{
    use HasFactory, HasTranslations, Localizable;
    protected $guarded = ['id'];
    public $translatable = ['period'];


    public function product (){
        return $this->belongsTo(Product::class, 'rental_period', 'id');
    }

    public function products (){
        return $this->hasMany(Product::class, 'rental_period', 'id');
    }
}
