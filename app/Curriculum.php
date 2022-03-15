<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    //
    protected $fillable=[
        'programid',
        'level',
        'semester',
        'coursecode',
        'iscore',
        'status'

    ];

}
