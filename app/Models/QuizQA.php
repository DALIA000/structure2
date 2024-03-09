<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Localizable;
use Spatie\Translatable\HasTranslations;

class QuizQA extends Model
{
    use HasFactory, Localizable, HasTranslations;
    protected $guarded = ['id'];
    protected $casts = ['question' => 'json', 'answer' => 'json'];
    public $translatable = ['question', 'answer'];
}
