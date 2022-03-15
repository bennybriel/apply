<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDSScores extends Model
{
    //
    protected $fillable =[
        'id',
        'name',
        'formnumber',
        'session',
        'score',
        'status',
        'type'
    ];
}
