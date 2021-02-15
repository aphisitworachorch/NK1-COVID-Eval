<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionairePrototype;

class QuestionairePrototypeDesc extends Model
{
    use HasFactory;
    protected $table = 'questionaire_prototype_details';
    protected $fillable = [
        'questionaire_id','choices','translation'
    ];

    public function questionPrototype(){
        return $this->hasOne(QuestionairePrototype::class,'id','questionaire_id');
    }
}
