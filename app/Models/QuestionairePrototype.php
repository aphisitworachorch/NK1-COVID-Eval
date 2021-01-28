<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionairePrototype extends Model
{
    use HasFactory;
    protected $table = 'questionaire_prototype';
    protected $fillable = [
        'sections_id','question_type','question_title'
    ];
}
