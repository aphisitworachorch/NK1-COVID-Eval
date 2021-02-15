<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareGroupModel extends Model
{
    use HasFactory;
    protected $table = 'care_info';
    protected $fillable = [
        'care_name'
    ];
}
