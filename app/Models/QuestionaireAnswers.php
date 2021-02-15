<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaireAnswers extends Model
{
    use HasFactory;
    protected $table = 'questionaire_answers';
    protected $fillable = [
        'name','surname','church','care_group','answers', 'risk_score', 'risk_type'
    ];

    public function haveChurch():\Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ChurchInfoModel::class,'id','church');
    }

    public function haveCare():\Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CareGroupModel::class,'id','care_group');
    }
}
