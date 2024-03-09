<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function qas()
    {
        return $this->hasMany(QuizQA::class, 'quiz_id');
    }
}
