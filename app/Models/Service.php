<?php

namespace App\Models;

use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use Localizable;

    protected $guarded = ['id'];
    protected $casts = ['name' => 'json'];
    public $translatable = ['name'];

    public function Agent(){
        return $this->belongsTo(Agent::class, 'service', 'id');
    }
}
