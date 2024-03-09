<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;

class Agent extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Localizable, HasTranslations;

    protected $guarded = ['id'];
    protected $casts = ['service' => 'json', 'first_name' => 'json', 'last_name' => 'json', 'position' => 'json', 'lang' => 'json',];
    public $translatable = ['first_name', 'last_name', 'position', 'lang'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'agent', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'agent', 'id');
    }

    public function getServiceAttribute()
    {
        $serviceData = $this->attributes['service'];
        $service = json_decode($serviceData, true);
        return Service::whereIn('id', $service)->get();
    }

    public function clicks()
    {
        return $this->hasMany(AgentClick::class, 'agent_id');
    }
}
