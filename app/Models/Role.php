<?php

namespace App\Models;
use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Translatable\HasTranslations;

class Role extends SpatieRole
{
    use HasTranslations;
    use HasFactory;
    use Localizable;

    public $translatable = ['title'];
    protected $casts =['title' => 'array'];
}
