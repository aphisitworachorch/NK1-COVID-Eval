<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInModel extends Model
{
    use HasFactory;
    protected $table = 'checkin';
    protected $fillable = [
        'user_id'
    ];
}
