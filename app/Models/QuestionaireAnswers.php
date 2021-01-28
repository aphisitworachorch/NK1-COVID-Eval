<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaireAnswers extends Model
{
    use HasFactory;
    protected $table = 'questionaire_answers';
    protected $fillable = [
        'questionaire_id','prefix','name','surname','church','care_group','answers'
    ];
}
