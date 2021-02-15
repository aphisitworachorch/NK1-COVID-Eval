<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchInfoModel extends Model
{
    use HasFactory;
    protected $table = 'church_info';
    protected $fillable = [
        'church_name'
    ];
}
