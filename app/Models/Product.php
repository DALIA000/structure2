<?php

namespace App\Models;
use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['title' => 'json', 'description' => 'json', 'location' => 'json', 'address' => 'json', 'amenities'=> 'json', 'badge'=>'json', 'type' => 'json'];
    public $translatable = ['title', 'description', 'address', 'badge'];

    public function Agent(){
        return $this->hasOne(Agent::class, 'id', 'agent');
    }

    public function Developer(){
        return $this->hasOne(Developer::class, 'id', 'developer');
    }

    // public function Type(){
    //     return $this->hasOne(Type::class, 'id', 'type');
    // }

    public function getTypeAttribute()
    {
        $typeData = $this->attributes['type'];
        $type = json_decode($typeData, true);
        return Type::whereIn('id', $type)->get();
    }

    public function Community(){
        return $this->hasOne(Community::class, 'id', 'community');
    }

    public function Category(){
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function Details(){
        return $this->hasOne(ProductDetails::class, 'id', 'details');
    }
    public function getAmenitiesAttribute(){
        $amenitiesData = $this->attributes['amenities'];
        $amenities = json_decode($amenitiesData, true);
        return Amenities::whereIn('id', $amenities)->get();
    }

    public function period(){
        return $this->belongsTo(RentalPeriod::class,'rental_period');
    }
}
