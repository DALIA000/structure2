<?php

namespace App\Models;
use App\Traits\Localizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Translatable\HasTranslations;


class Permission extends SpatiePermission
{
    use HasTranslations;
    use HasFactory;
    use Localizable;
    public $translatable = ['title'];
    protected $casts =['title' => 'array'];
}
