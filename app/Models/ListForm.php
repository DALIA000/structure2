<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ListForm extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function availability()
    {
        return $this->belongsTo(Availability::class, 'availability_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
